<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock")){
	echo GetMessage("IBLOCK_MODULE_MISSING");
}
if(!CModule::IncludeModule("marketing")){
	echo GetMessage("MARKETING_MODULE_MISSING");
}

// $arParams - Массив параметров компонента
// $arResult - Массив значений для шаблона

$arResult["GRID_ID"] = "action_grid";

// Получаем значения для полей типа "Список"
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

    ob_start();
    $GLOBALS["APPLICATION"]->IncludeComponent('bitrix:intranet.user.selector', '', array(
                   'INPUT_NAME' => "PROPERTY_RESPONSIBLE",
                   //'INPUT_NAME_STRING' => "RESPONSIBLE_STRING",
                   //'INPUT_NAME_SUSPICIOUS' => "RESPONSIBLE_NAME",
                   //'TEXTAREA_MIN_HEIGHT' => 30,
                   //'TEXTAREA_MAX_HEIGHT' => 60,
                   //'INPUT_VALUE_STRING' => implode("\n", $arUsers),
                   'EXTERNAL' => 'A',
                   'MULTIPLE' => 'N'
                   //'SOCNET_GROUP_ID' => ($arParams["TASK_TYPE"] == "group" ? $arParams["OWNER_ID"] : "")
                    )
    );
    $sVal1 = ob_get_contents();
    ob_end_clean();


// Поля для фильтрации
$arResult["FILTER"]=array(
		array("id"=>"FIND", "name"=>"Найти", "type"=>"quick", "items"=>array("ID"=>"ID", "NAME"=>"Название")),
		array("id"=>"PROPERTY_TARGET", "name"=>"Цель"),
		array("id"=>"PROPERTY_FAMILY", "name"=>"Семейство воздействия", "type"=>"list", "items"=>array(""=>"Все")+$arResult["LIST"]["family"]),
		array("id"=>"PROPERTY_TYPE", "name"=>"Тип воздействия", "type"=>"list", "items"=>array(""=>"Все")+$arResult["LIST"]["type"]),
		array("id"=>"PROPERTY_SOURCE", "name"=>"Источник", "type"=>"list", "items"=>array(""=>"Все")+$arResult["LIST"]["source"]),
		array("id"=>"PROPERTY_RESPONSIBLE", "name"=>"Ответственный","type"=>"custom","value"=>$sVal1),
		array("id"=>"PROPERTY_TERRITORY", "name"=>"Территория"),
		array("id"=>"PROPERTY_STATUS", "name"=>"Статус", "type"=>"list", "items"=>array(""=>"Все")+$arResult["LIST"]["status"]),
		array("id"=>"PROPERTY_DATESTART", "name"=>"Дата начала", "type"=>"date"),
		array("id"=>"PROPERTY_DATEFINISH", "name"=>"Дата завершения", "type"=>"date"),
		array("id"=>"PROPERTY_TARGETCLIENT", "name"=>"Целевая аудитория", "type"=>"list", "items"=>array(""=>"Все")+$arResult["LIST"]["targetClient"]),
		array("id"=>"PROPERTY_COUNTOBJECT", "name"=>"Количество объектов"),
		array("id"=>"PROPERTY_PLANNEDRESPONSE", "name"=>"Планируемый отклик"),
		array("id"=>"PROPERTY_PLANNEDBUDJET", "name"=>"Планируемый бюджет"),
		array("id"=>"PROPERTY_ACTUALBUDJET", "name"=>"Фактический бюджет"),
		array("id"=>"PROPERTY_SALESPROGRAMM", "name"=>"План продаж"),
		array("id"=>"PROPERTY_ACTUALSALES", "name"=>"Фактические продажи"),
		//array("id"=>"PROPERTY_TEAMUSERS", "name"=>"Команда пользователей"), //bublebox
		//array("id"=>"PROPERTY_TEAMCONTACTS", "name"=>"Команда контрагентов"), //bublebox
	);
// Список заголовков таблицы
$arResult["HEADERS"]=array(
		array("id"=>"ID", "name"=>"ID", "sort"=>"id", "default"=>true, "editable"=>false),
		array("id"=>"NAME", "name"=>"Название", "sort"=>"name", "default"=>true, "editable"=>array("size"=>20, "maxlength"=>255)),
		array("id"=>"PROPERTY_TARGET_VALUE", "name"=>"Цель", "sort"=>"target", "default"=>false, "editable"=>array("size"=>20, "maxlength"=>255)),
		array("id"=>"PROPERTY_FAMILY_VALUE", "name"=>"Семейство воздействия", "sort"=>"family", "default"=>true, "editable"=>false),
		array("id"=>"PROPERTY_TYPE_VALUE", "name"=>"Тип воздействия", "sort"=>"type", "default"=>true, "editable"=>false),
		array("id"=>"PROPERTY_SOURCE_VALUE", "name"=>"Источник", "sort"=>"source", "default"=>false, "editable"=>false),
		array("id"=>"PROPERTY_RESPONSIBLE_VALUE", "name"=>"Ответственный", "sort"=>"responsible", "default"=>false, "editable"=>false),
		array("id"=>"PROPERTY_TERRITORY_VALUE", "name"=>"Территория", "sort"=>"territory", "default"=>true, "editable"=>array("size"=>20, "maxlength"=>255)),
		array("id"=>"PROPERTY_STATUS_VALUE", "name"=>"Статус", "sort"=>"status", "default"=>true, "editable"=>false),
		array("id"=>"PROPERTY_DATESTART_VALUE", "name"=>"Дата начала", "sort"=>"datestart", "default"=>false, "editable"=>false),
		array("id"=>"PROPERTY_DATEFINISH_VALUE", "name"=>"Дата завершения", "sort"=>"datefinish", "default"=>false, "editable"=>false),
		array("id"=>"PROPERTY_TARGETCLIENT_VALUE", "name"=>"Целевая аудитория", "sort"=>"targetclient", "default"=>false, "editable"=>false),
		array("id"=>"PROPERTY_COUNTOBJECT_VALUE", "name"=>"Количество объектов", "sort"=>"countobject", "default"=>false, "editable"=>false),
		array("id"=>"PROPERTY_PLANNEDRESPONSE_VALUE", "name"=>"Планируемый отклик", "sort"=>"plannedresponse", "default"=>false, "editable"=>false),
		array("id"=>"PROPERTY_PLANNEDBUDJET_VALUE", "name"=>"Планируемый бюджет", "sort"=>"plannedbudjet", "default"=>false, "editable"=>false),
		array("id"=>"PROPERTY_ACTUALBUDJET_VALUE", "name"=>"Фактический бюджет", "sort"=>"actualbudjet", "default"=>false, "editable"=>false),
		array("id"=>"PROPERTY_SALESPROGRAM_VALUE", "name"=>"Фактический бюджет", "sort"=>"salesprogramm", "default"=>false, "editable"=>false),
		array("id"=>"PROPERTY_ACTUALSALES_VALUE", "name"=>"Фактические продажи", "sort"=>"actualsales", "default"=>false, "editable"=>false),
		//array("id"=>"TEAMUSERS", "name"=>"Команда пользователей", "sort"=>"teamusers", "default"=>false, "editable"=>false),
		//array("id"=>"TEAMCONTACTS", "name"=>"Команда контрагентов", "sort"=>"teamcontacts", "default"=>false, "editable"=>false)
	);

//инициализируем объект с настройками пользователя для нашего грида
$grid_options = new CGridOptions($arResult["GRID_ID"]);
//какую сортировку сохранил пользователь (передаем то, что по умолчанию)
$aSort = $grid_options->GetSorting(array("sort"=>array("id"=>"desc"), "vars"=>array("by"=>"by", "order"=>"order")));
//размер страницы в постраничке (передаем умолчания)
$aNav = $grid_options->GetNavParams(array("nPageSize"=>10));
//получим текущий фильтр (передаем описанный выше фильтр)
$aFilter = $grid_options->GetFilter($arResult["FILTER"]);

if(isset($aFilter["FIND"])){
	$aFilter[$aFilter["FIND_list"]]=$aFilter["FIND"];
	unset($aFilter["FIND"],$aFilter["FIND_list"]);
}



if(count($aFilter) > 0){
    foreach ($aFilter as $key => $value) {
        switch ($key) {
            case 'NAME':
                $aFilter["NAME"] = "%".$value."%";
                break;
            case 'PROPERTY_TARGET':
                $aFilter["PROPERTY_TARGET"] = "%".$value."%";
                break;
            case 'PROPERTY_TERRITORY':
                $aFilter["PROPERTY_TERRITORY"] = "%".$value."%";
                break;
            
            default:
                
                break;
        }
    }
}

$aFilter["IBLOCK_ID"] = $arParams["IBLOCK_ACTION"];

/**
 * Фильтр для даты начала
 */
if($aFilter["PROPERTY_DATESTART_from"]&&$aFilter["PROPERTY_DATESTART_to"]){
   $aFilter[">=PROPERTY_DATESTART"] = ConvertDateTime($aFilter["PROPERTY_DATESTART_from"], "YYYY-MM-DD")." 00:00:00";
   $aFilter["<=PROPERTY_DATESTART"] = ConvertDateTime($aFilter["PROPERTY_DATESTART_to"], "YYYY-MM-DD")." 23:59:59";
} elseif ($aFilter["PROPERTY_DATESTART_from"]) {
   $aFilter[">=PROPERTY_DATESTART"] = ConvertDateTime($aFilter["PROPERTY_DATESTART_from"], "YYYY-MM-DD")." 00:00:00";
} elseif($aFilter["PROPERTY_DATESTART_to"]){
   $aFilter["<=PROPERTY_DATESTART"] = ConvertDateTime($aFilter["PROPERTY_DATESTART_to"], "YYYY-MM-DD")." 23:59:59";
}


/**
 * Фильтр для даты завершения
 */
if($aFilter["PROPERTY_DATEFINISH_from"]&&$aFilter["PROPERTY_DATEFINISH_to"]){
   $aFilter[">=PROPERTY_DATEFINISH"] = ConvertDateTime($aFilter["PROPERTY_DATEFINISH_from"], "YYYY-MM-DD")." 00:00:00";
   $aFilter["<=PROPERTY_DATEFINISH"] = ConvertDateTime($aFilter["PROPERTY_DATEFINISH_to"], "YYYY-MM-DD")." 23:59:59";
} elseif ($aFilter["PROPERTY_DATEFINISH_from"]) {
   $aFilter[">=PROPERTY_DATEFINISH"] = ConvertDateTime($aFilter["PROPERTY_DATEFINISH_from"], "YYYY-MM-DD")." 00:00:00";
} elseif($aFilter["PROPERTY_DATEFINISH_to"]) {
   $aFilter["<=PROPERTY_DATEFINISH"] = ConvertDateTime($aFilter["PROPERTY_DATEFINISH_to"], "YYYY-MM-DD")." 23:59:59";
}

/**
 * Чистим фильтр
 */
   unset($aFilter["PROPERTY_DATEFINISH_from"]);
   unset($aFilter["PROPERTY_DATEFINISH_to"]);
   unset($aFilter["PROPERTY_DATEFINISH_datesel"]);
   unset($aFilter["PROPERTY_DATESTART_from"]);
   unset($aFilter["PROPERTY_DATESTART_to"]);
   unset($aFilter["PROPERTY_DATESTART_datesel"]);



/*echo "<pre>";
print_r($aFilter);
echo "</pre>";*/

//сортировка
$arResult["SORT"] = $aSort["sort"];
$arResult["SORT_VARS"] = $aSort["vars"];

//это собственно выборка данных с учетом сортировки и фильтра, указанных пользователем
$aSortArg = each($aSort["sort"]);
$iblock_el = new CIBlockElement;
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
   // "PROPERTY_teamusers",
   // "PROPERTY_teamcontacts"
);
$db_res=$iblock_el->GetList(array("SORT"=>"ASC"), $aFilter,0,0,$arSelectFields);


//постраничка с учетом размера страницы
$db_res->NavStart($aNav["nPageSize"]);

//в этом цикле построчно заполняем данные для грида
$aRows = array();
while($aRes = $db_res->GetNext())
{
    $rsUser = CUser::GetByID($aRes["PROPERTY_RESPONSIBLE_VALUE"]); //
    $arUser = $rsUser->Fetch();
    $aRes["PROPERTY_RESPONSIBLE_VALUE"] = $arUser["NAME"]." ".$arUser["LAST_NAME"];
       
	//в этой переменной - поля, требующие нестандартного отображения (не просто значение)
	$aCols = array(
			"PERSONAL_GENDER" => ($aRes["PERSONAL_GENDER"] == "M"? "Мужской":($aRes["PERSONAL_GENDER"] == "F"? "Женский":"")),
			"EMAIL" => '<a href="mailto:'.$aRes["EMAIL"].'">'.$aRes["EMAIL"].'</a>',
			"ID" => '<a href="'.$APPLICATION->GetCurPage().'?ID='.$aRes["ID"].'">'.$aRes["ID"].'</a>',
			"LOGIN" => '<a href="main.interface.form.php?ID='.$aRes["ID"].'">'.$aRes["LOGIN"].'</a>',
	);

	//это определения для меню действий над строкой
	$aActions = Array(
            array("ICONCLASS"=>"view", "TEXT"=>"Просмотреть воздействие", "ONCLICK"=>"jsUtils.Redirect(arguments, '".$arParams["DETAIL_URL"]."?ID=".$aRes["ID"]."')", "DEFAULT"=>true),
			array("ICONCLASS"=>"edit", "TEXT"=>"Изменить", "ONCLICK"=>"jsUtils.Redirect(arguments, '".$arParams["EDIT_URL"]."?ID=".$aRes["ID"]."')"),
           // array("ICONCLASS"=>"copy", "TEXT"=>"Добавить копию", "ONCLICK"=>"jsUtils.Redirect(arguments, '/bitrix/admin/user_edit.php?COPY_ID=".$aRes["ID"]."')"),
			array("SEPARATOR"=>true),
			array("ICONCLASS"=>"delete", "TEXT"=>"Удалить", "ONCLICK"=>"if(confirm('Вы уверены, что хотите удалить данную запись?')) window.location='?action=delete&ID=".$aRes["ID"]."&".bitrix_sessid_get()."';"),
	);

	//запомнили данные. "data" - вся выборка,  "editable" - можно редактировать строку или нет
	$aRows[] = array("data"=>$aRes, "actions"=>$aActions, "columns"=>$aCols, "editable"=>($aRes["ID"]==11? false:true));
}

//наши накопленные данные
$arResult["ROWS"] = $aRows;


$this->IncludeComponentTemplate();
?>
