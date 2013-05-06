<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Подключение модуля
/*if(!CModule::IncludeModule("module_name"))
	return;*/

$arComponentParameters = array(
	// Список гупп параметров
	"GROUPS" => array(
		/*"GROUP_NAME" => array(
			"SORT" => 100,				// Индекс сортировки
			"NAME" => GetMessage("GROUP_NAME")	// Имя группы параметров
		)*/
	),
	// Список параметров
	"PARAMETERS" => array(
		"IBLOCK_ACTION" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_ACTION"),
			"TYPE" => "STRING"
		),
		"IBLOCK_TEAM" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_TEAM"),
			"TYPE" => "STRING"
		),
		"IBLOCK_REVIEWS" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_REVIEWS"), 
			"TYPE" => "STRING"
		),
		"DETAIL_URL" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("DETAIL_URL"),
			"TYPE" => "STRING"
		),
        "EDIT_URL" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("EDIT_URL"),
            "TYPE" => "STRING"
        ),
		"CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
	),
);
?>
