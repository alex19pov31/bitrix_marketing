<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock")){
	echo GetMessage("IBLOCK_MODULE_MISSING");
}
if (!CModule::IncludeModule("crm"))
{
	ShowError(GetMessage("CRM_MODULE_NOT_INSTALLED"));
	return;
}

CModule::IncludeModule("fileman");

if (IsModuleInstalled("bizproc"))
{
	if (!CModule::IncludeModule("bizproc"))
	{
		ShowError(GetMessage("BIZPROC_MODULE_NOT_INSTALLED"));
		return;
	}
}

// $arParams - Массив параметров компонента
// $arResult - Массив значений для шаблона



//здесь обработка POST
if($_REQUEST['apply']||$_REQUEST['saveAndView']){
    /**
     * NAME
     * TARGET
     * ACTIVE
     * FAMILY
     * TYPE
     * SOURCE
     * STATUS
     * ASSIGNED_BY_ID
     * TERRITORY
     * DATESTART
     * DATEFINISH 
     * TARGETCLIENT
     * COUNTOBJECT
     * PLANNEDRESPONSE
     * PLANNEDBUDJET
     * ACTUALBUDJET
     * SALESPROGRAMM
     * ACTUALSALES
     * CONTACT_ID
     * TEAMUSERS_ID
     */

     $el = new CIBlockElement;
     $PROP = array(
        "target" => $_REQUEST["TARGET"],
        "family" => $_REQUEST["FAMILY"],
        "type" => $_REQUEST["TYPE"],
        "source" => $_REQUEST["SOURCE"],
        "responsible" => $_REQUEST["ASSIGNED_BY_ID"],
        "territory" => $_REQUEST["TERRITORY"],
        "status" => $_REQUEST["STATUS"],
        "dateStart" => $_REQUEST["DATESTART"],
        "dateFinish" => $_REQUEST["DATEFINISH"],
        "targetClient" => $_REQUEST["TARGETCLIENT"],
        "countObject" => $_REQUEST["COUNTOBJECT"],
        "plannedResponse" => $_REQUEST["PLANNEDRESPONSE"],
        "plannedBudget" => $_REQUEST["PLANNEDBUDJET"],
        "salesProgram" => $_REQUEST["SALESPROGRAMM"],
        "actualSales" => $_REQUEST["ACTUALSALES"],
        "teamUsers" => $_REQUEST["TEAMUSERS_ID"],
        "teamContacts" => $_REQUEST["CONTACT_ID"],
     );
     
     $elementProps = array(
        "MODIFIED_BY" => $USER->GetID(),
        "IBLOCK_SECTION_ID" => false,
        "IBLOCK_ID" => $arParams["IBLOCK_ACTION"],
        "PROPERTY_VALUES" => $PROP,
        "NAME" => $_REQUEST["NAME"],
        "ACTIVE" => $_REQUEST["ACTIVE"],
     );
     
     if($arParams["IBLOCK_ELEMENT"] > 0){
         if($elementProps["NAME"]){
            if($el->Update($arParams["IBLOCK_ELEMENT"], $elementProps)){
                ShowMessage(array("MESSAGE" => "Изменена запись с ID: ".$arParams["IBLOCK_ELEMENT"], "TYPE" => "OK"));
            } else {
                ShowMessage(array("MESSAGE" => $el->LAST_ERROR,"TYPE" => "ERROR"));
            }
          } else{
                ShowMessage(array("MESSAGE" => "Не введено название", "TYPE" => "ERROR")); 
          }
     } else{
        /*echo "<pre>";
        print_r($elementProps);
        echo "</pre>";*/
        if($elementProps["NAME"]){
            if($RECORD_ID = $el->Add($elementProps)){
                ShowMessage(array("MESSAGE" => "Создана новая запись с ID: ".$RECORD_ID, "TYPE" => "OK"));
            } else {
                ShowMessage(array("MESSAGE" => $el->LAST_ERROR,"TYPE" => "ERROR"));
            }
        } else{
            ShowMessage(array("MESSAGE" => "Не введено название", "TYPE" => "ERROR")); 
        }  
     }
}




//получаем данные пользователя
if($arParams["IBLOCK_ELEMENT"]>0){
    $aFilter = array(
        "IBLOCK_ID" => $arParams["IBLOCK_ACTION"],
        "ID" => $arParams["IBLOCK_ELEMENT"]
    );
    $arSelectFields = array(
        "NAME",
        "ID",
        "PROPERTY_target",
        "PROPERTY_family",
        "PROPERTY_type",
        "PROPERTY_source",
        "PROPERTY_responsible",
        "PROPERTY_territory",
        "PROPERTY_status",
        "PROPERTY_datestart",
        "PROPERTY_datefinish",
        "PROPERTY_targetclient",
        "PROPERTY_countobject",
        "PROPERTY_plannedresponse",
        "PROPERTY_plannedBudget",
        "PROPERTY_actualbudjet",
        "PROPERTY_salesprogram",
        "PROPERTY_actualsales",
        //"PROPERTY_teamusers",
        //"PROPERTY_teamcontacts"
    );
	$db_res = CIBlockElement::GetList(array("SORT"=>"ASC"), $aFilter,0,0,$arSelectFields);
	$arResult["DATA"] = $db_res->Fetch();
    
    
    $db_res = CIBlockElement::GetList(array("SORT"=>"ASC"), $aFilter,0,0, array("PROPERTY_teamusers"));
    while($arRes = $db_res->Fetch()) $arResult["DATA"]["TEAMUSERS"][] = $arRes["PROPERTY_TEAMUSERS_VALUE"];
    
    $db_res = CIBlockElement::GetList(array("SORT"=>"ASC"), $aFilter,0,0, array("PROPERTY_teamcontacts"));
    while($arRes = $db_res->Fetch()) $arResult["DATA"]["TEAMCONTACTS"][] = $arRes["PROPERTY_TEAMCONTACTS_VALUE"];

    /*echo "<pre>";
    print_r($arResult["DATA"]);
    echo "</pre>";   */     
 
} else{
	$el = new CIBlockElement();
	$arResult["DATA"] = false;
}

$PropertyRes = CIBlockPropertyEnum::GetList(
		array(),
		array(
				"IBLOCK_ID"=>$arParams["IBLOCK_ACTION"], 
				"CODE"=>array("family","type","source","status","targetclient")
			)
		);
while($arProperty = $PropertyRes->Fetch()){
	$arResult["LIST"][$arProperty["PROPERTY_CODE"]][$arProperty["ID"]] = $arProperty["VALUE"];
}

//уникальный идентификатор формы
$arResult["FORM_ID"] = "action_form";

    ob_start();
    $GLOBALS['APPLICATION']->IncludeComponent('bitrix:crm.entity.selector',
        '',
        array(
            "ENTITY_TYPE" => "CONTACT",
            "INPUT_NAME" => "CONTACT_ID",
            'INPUT_VALUE' => isset($arResult["DATA"]["TEAMCONTACTS"]) ? $arResult["DATA"]["TEAMCONTACTS"] : '',
            'FORM_NAME' => $arResult["FORM_ID"] ,
            'MULTIPLE' => 'Y'
        ),
        false,
        array('HIDE_ICONS' => 'Y')
    );
    $sVal = ob_get_contents();
    ob_end_clean();

    ob_start();
    $GLOBALS["APPLICATION"]->IncludeComponent('bitrix:intranet.user.selector', '', array(
                   'INPUT_NAME' => "TEAMUSERS_ID",
                   'INPUT_NAME_STRING' => "TEAMUSERS_STRING",
                   'INPUT_NAME_SUSPICIOUS' => "TEAMUSERS_NAME",
                   'TEXTAREA_MIN_HEIGHT' => 60,
                   'TEXTAREA_MAX_HEIGHT' => 80,
                   'INPUT_VALUE' => isset($arResult["DATA"]["TEAMUSERS"]) ? $arResult["DATA"]["TEAMUSERS"] : '',
                   //'INPUT_VALUE_STRING' => implode("\n", $arUsers),
                   'EXTERNAL' => 'A',
                   'MULTIPLE' => 'Y',
                   //'SOCNET_GROUP_ID' => ($arParams["TASK_TYPE"] == "group" ? $arParams["OWNER_ID"] : "")
         )
    );
    $sVal1 = ob_get_contents();
    ob_end_clean();


// Вкладка основное
$arResult["FIELDS"]["tab_1"] = array(
	array(
		"id" => "ACTIVE",
		"name" => GetMessage("FIELD_ACTIVE"),
		"params" => array(),
		//"items" => $arEvent,
		"type"=>"checkbox",
		//"type" => "list",
		//"value" => (isset($_REQUEST["bizproc_event_".$bizProcIndex]) ? $_REQUEST["bizproc_event_".$bizProcIndex] : "")
	),
    array(
        "id" => "NAME",
        "required"=>true,   
        "type" => "custom",
        "name" => GetMessage("FIELD_NAME"),
        "value" => "<b>".$arResult["DATA"]["NAME"]."</b>"
    ),  
	array(
		"id" => "TARGET",
        "type" => "custom",
		"name" => GetMessage("FIELD_TARGET"),
        "value" => "<i>".$arResult["DATA"]["PROPERTY_TARGET_VALUE"]."</i>"
	),
	array(
		"id" => "FAMILY",
		"name" => GetMessage("FIELD_FAMILY"),
		"items" => $arResult["LIST"]["family"],
        "type" => "custom",
        "value" => $arResult["DATA"]["PROPERTY_FAMILY_VALUE"]
	),
	array(
		"id" => "TYPE",
		"name" => GetMessage("FIELD_TYPE"),
		"items" => $arResult["LIST"]["type"],
        "type" => "custom",
        "value" => $arResult["DATA"]["PROPERTY_TYPE_VALUE"]
	),
	array(
		"id" => "SOURCE",
		"name" => GetMessage("FIELD_SOURCE"),
		"items" => $arResult["LIST"]["source"],
        "type" => "custom",
        "value" => $arResult["DATA"]["PROPERTY_SOURCE_VALUE"]
	),
	array(
		"id" => "STATUS",
		"name" => GetMessage("FIELD_STATUS"),
		"items" => $arResult["LIST"]["status"],
        "type" => "custom",
        "value" => $arResult["DATA"]["PROPERTY_STATUS_VALUE"]
	),
	array(
		"id" => "RESPONSIBLE",
		"name" => GetMessage("FIELD_RESPONSIBLE"),
		"componentParams" => array(
				"NAME" => "action_edit_resonsible",
				"INPUT_NAME" => "ASSIGNED_BY_ID",
				"SEARCH_INPUT_NAME" => "ASSIGNED_BY_NAME",
		),
        "type" => "intranet_user_search",
		"value" => $arResult["DATA"]["PROPERTY_RESPONSIBLE_VALUE"] ? $arResult["DATA"]["PROPERTY_RESPONSIBLE_VALUE"] : $USER->GetID()
	),
	array(
		"id" => "TERRITORY",
		"name" => GetMessage("FIELD_TERRITORY"),
        "type" => "custom",
        "value" => $arResult["DATA"]["PROPERTY_TERRITORY_VALUE"]
	),
	array(
		"id" => "DATESTART",
		"name" => GetMessage("FIELD_DATESTART"),
		"type" => "date",
		//"value" => ConvertTimeStamp(false, "FULL"),
        "value" => $arResult["DATA"]["PROPERTY_DATESTART_VALUE"] ? $arResult["DATA"]["PROPERTY_DATESTART_VALUE"] : ConvertTimeStamp(false, "FULL")
	),
	array(
		"id" => "DATEFINISH",
		"name" => GetMessage("FIELD_DATEFINISH"),
		"type" => "date",
        "value" => $arResult["DATA"]["PROPERTY_DATEFINISH_VALUE"]
	),

);


// Вкладка дополнительно
$arResult["FIELDS"]["tab_2"] = array(
        //array("id"=>"DATE_REGISTER", "name"=>"Зарегистрирован",  "type"=>"custom","value"=>"123"),
        array(
                "id" => "TARGETCLIENT",
                "name" => GetMessage("FIELD_TARGETCLIENT"),
                "params" => array(),
                "items" => $arResult["LIST"]["targetClient"],
                "type" => "custom",
                "value" => $arResult["DATA"]["PROPERTY_TARGETCLIENT_VALUE"]
        ),
        array(
                "id" => "COUNTOBJECT",
                "name" => GetMessage("FIELD_COUNTOBJECT"),
                "params" => array(),
                "type" => "custom",
                "value" => $arResult["DATA"]["PROPERTY_COUNTOBJECT_VALUE"] ? $arResult["DATA"]["PROPERTY_COUNTOBJECT_VALUE"] : 0
        ),
        array(
                "id" => "PLANNEDRESPONSE",
                "name" => GetMessage("FIELD_PLANNEDRESPONSE"),
                "params" => array(),
                "type" => "custom",
                "value" => $arResult["DATA"]["PROPERTY_PLANNEDRESPONSE_VALUE"] ? $arResult["DATA"]["PROPERTY_PLANNEDRESPONSE_VALUE"] : 0
        ),
        array(
                "id" => "PLANNEDBUDJET",
                "name" => GetMessage("FIELD_PLANNEDBUDJET"),
                "params" => array(),
                "type" => "custom",
                "value" => $arResult["DATA"]["PROPERTY_PLANNEDBUDGET_VALUE"] ? $arResult["DATA"]["PROPERTY_PLANNEDBUDGET_VALUE"] : 0
        ),
        /*array(
                "id" => "ACTUALBUDJET",
                "name" => GetMessage("FIELD_ACTUALBUDJET"),
                "params" => array(),
                "value" => $arResult["DATA"]["PROPERTY_PLANNEDRESPONSE_VALUE"] ? $arResult["DATA"]["PROPERTY_PLANNEDRESPONSE_VALUE"] : 0
        ),*/
        array(
                "id" => "SALESPROGRAMM",
                "name" => GetMessage("FIELD_SALESPROGRAMM"),
                "params" => array(),
                "type" => "custom",
                "value" => $arResult["DATA"]["PROPERTY_SALESPROGRAM_VALUE"] ? $arResult["DATA"]["PROPERTY_SALESPROGRAM_VALUE"] : 0
        ),
        array(
                "id" => "ACTUALSALES",
                "name" => GetMessage("FIELD_ACTUALSALES"),
                "params" => array(),
                "type" => "custom",
                "value" => $arResult["DATA"]["PROPERTY_ACTUALSALES_VALUE"] ? $arResult["DATA"]["PROPERTY_ACTUALSALES_VALUE"] : 0
        ),
        array(
                "id" => "TEAM_USERS",
                "name" => GetMessage("FIELD_TEAM_USERS"),
                "params" => array(),
            /*  "items" => array("" => "(все)", 0 => "Руководители учреждений", 1 => "Пользователи сайта"),
                "type" => "list"*/
                'type' => 'custom',
                'wrap' => true,
                'value' => $sVal1
        ),
        array(
                "id" => "TEAM_CONTACTS",
                "name" => GetMessage("FIELD_TEAM_CONTACTS"),
                "params" => array(),
                "MULTIPLE" => "Y",
                'type' => 'custom',
                'wrap' => true,
                'value' => $sVal
        ),
);

$this->IncludeComponentTemplate();
?>
