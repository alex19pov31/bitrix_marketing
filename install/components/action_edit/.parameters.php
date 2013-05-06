<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Подключение модуля
if(!CModule::IncludeModule("iblock"))
	return;

$arComponentParameters = array(
	// Список гупп параметров
	"GROUPS" => array(
	),
	// Список параметров
	"PARAMETERS" => array(
		"IBLOCK_ACTION" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_ACTION"),
			"TYPE" => "STRING"
		),
        "IBLOCK_ELEMENT" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBLOCK_ELEMENT"),
            "TYPE" => "STRING"
        ),
        "LIST_URL" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("LIST_URL"),
            "TYPE" => "STRING"
        ),
        "DETAIL_URL" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("DETAIL_URL"),
            "TYPE" => "STRING"
        ),
		"CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
	),
);
?>
