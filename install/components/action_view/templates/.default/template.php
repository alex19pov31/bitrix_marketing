<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// CSS для кнопок
$APPLICATION->AddHeadString('<link href="/bitrix/components/bitrix/crm.company.menu/templates/.default/style.css";  type="text/css" rel="stylesheet" />',true);
global $APPLICATION;

$arTabs = array();
$arTabs[] = array(
		"id" => "tab_1",
		"name" => "Основное",
		"title" => "Регистрационная информация",
		"icon" => "",
		"fields"=> $arResult["FIELDS"]["tab_1"]
);
$arTabs[] = array(
		"id" => "tab_2",
		"name" => "Дополнительно",
		"title" => "Дополнительная информация",
		"icon" => "",
		"fields"=> $arResult["FIELDS"]["tab_2"]
);
?>
<?$APPLICATION->IncludeComponent(
   "bitrix:main.interface.toolbar",
   "",
   array(
      "BUTTONS"=>array(
         array(
            "TEXT"=>"Список",
            "TITLE"=>"Список воздействий",
            "LINK"=>$arParams["LIST_URL"],
            "ICON"=>"btn-list",
         ),
         array(
            "TEXT"=>"Редактировать",
            "TITLE"=>"Список воздействий",
            "LINK"=>$arParams["EDIT_URL"]."?ID=".$_GET["ID"],
            "ICON"=>"btn-edit",
         ),
      ),
   ),
   $component
);?>

<?$APPLICATION->IncludeComponent(
   "bitrix:crm.interface.form",
   "show",
   array(
//идентификатор формы
      "FORM_ID"=>$arResult["FORM_ID"],
	  //'EMPHASIZED_HEADERS' => array('NAME','TARGET'),
//описание вкладок формы
      "TABS"=>$arTabs,
//кнопки формы, возможны кастомные кнопки в виде html в "custom_html"
      "BUTTONS"=>array("back_url"=>$arParams["LIST_URL"], "custom_html"=>"", "standard_buttons"=>true),
//данные для редактирования
      "DATA"=>$arResult["DATA"],
   ),
   $component
);
?>