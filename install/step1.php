<?php
if(!check_bitrix_sessid()) return;
$obBlocktype = new CIBlockType;
$ib = new CIBlock;
$ibp = new CIBlockProperty;
// Список сайтов
$site_res = CSite::GetList($by="sort",$order="desc",Array("ACTIVE"=>"Y"));
while ($site = $site_res->Fetch()) $site_list[] = $site["ID"];


// Новый тип инфоблоков
$arFields = Array(
		'ID'=>'marketing',
		'SECTIONS'=>'Y',
		'IN_RSS'=>'N',
		'SORT'=>100,
		'LANG'=>Array(
				'en'=>Array(
						'NAME'=>'Marketing',
						'SECTION_NAME'=>'Sections',
						'ELEMENT_NAME'=>'Elements'
				),
				'ru'=>Array(
						'NAME'=>'Маркетинг',
						'SECTION_NAME'=>'Разделы',
						'ELEMENT_NAME'=>'Элементы'
				)
		)
);
$res = $obBlocktype->Add($arFields);
if(!$res) {
	echo 'Error: '.$obBlocktype->LAST_ERROR.'<br>';
	return;
}

// Инфоблок команда
$arFields = Array(
		"ACTIVE" => "Y",
		"NAME" => "Команда",
		"CODE" => "team",
		"IBLOCK_TYPE_ID" => $res,
		"SITE_ID" => $site_list
);
$team = $ib->Add($arFields);
if(!$team) {
	echo 'Error: '.$ib->LAST_ERROR.'<br>';
	return;
}
else{
	$arFields = Array();
	$arFields[] = Array(
			"NAME" => GetMessage("TEAMUSER_PROP_USER"),
			"ACTIVE" => "Y",
			"SORT" => "100",
			"CODE" => "user",
			"PROPERTY_TYPE" => "N",
			"MULTIPLE" => "N",
			"IBLOCK_ID" => $team
	);
	$arFields[] = Array(
			"NAME" => GetMessage("TEAMUSER_PROP_ROLE"),
			"ACTIVE" => "Y",
			"SORT" => "100",
			"CODE" => "role",
			"PROPERTY_TYPE" => "S",
			"MULTIPLE" => "N",
			"IBLOCK_ID" => $team
	);
	$arFields[] = Array(
			"NAME" => GetMessage("TEAMUSER_PROP_TYPE"),
			"ACTIVE" => "Y",
			"SORT" => "100",
			"CODE" => "type",
			"PROPERTY_TYPE" => "S",
			"MULTIPLE" => "N",
			"IBLOCK_ID" => $team
	);
    foreach ($arFields as $arField) $ibp->Add($arField);
}

// Инфоблок отзывы
$arFields = Array(
		"ACTIVE" => "Y",
		"NAME" => "Отзывы",
		"CODE" => "reviews",
		"IBLOCK_TYPE_ID" => $res,
		"SITE_ID" => $site_list
);
$reviews = $ib->Add($arFields);
if(!$reviews) {
	echo 'Error: '.$ib->LAST_ERROR.'<br>';
	return;
}
else{
	$arFields = Array();
	$arFields[] = Array(
			"NAME" => GetMessage("REVIEWS_CRM_CONTACT"),
			"ACTIVE" => "Y",
			"SORT" => "100",
			"CODE" => "CrmContact",
			"PROPERTY_TYPE" => "N",
			"MULTIPLE" => "N",
			"IBLOCK_ID" => $t_client
	);
	$arFields[] = Array(
			"NAME" => GetMessage("REVIEWS_PROP_COMMENT"),
			"ACTIVE" => "Y",
			"SORT" => "100",
			"CODE" => "comment",
			"PROPERTY_TYPE" => "S",
			"MULTIPLE" => "N",
			"IBLOCK_ID" => $t_client
	);
	$arFields[] = Array(
			"NAME" => GetMessage("REVIEWS_PROP_INVITE"),
			"ACTIVE" => "Y",
			"SORT" => "100",
			"CODE" => "invite",
			"PROPERTY_TYPE" => "S",
			"MULTIPLE" => "N",
			"DEFAULT_VALUE"=>"N",
			"IBLOCK_ID" => $t_client
	);
	foreach ($arFields as $arField) $ibp->Add($arField);
}

// Инфоблок воздействия
$arFields = Array(
		"ACTIVE" => "Y",
		"NAME" => "Воздействия",
		"CODE" => "action",
		"IBLOCK_TYPE_ID" => $res,
		"SITE_ID" => $site_list
);
$res = $ib->Add($arFields);
if(!$res) {
	echo 'Error: '.$ib->LAST_ERROR.'<br>';
	return;
}
else{
	$arFields = Array();
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_TARGET"),
			"ACTIVE" => "Y",
			"SORT" => "100",
			"CODE" => "target",
			"PROPERTY_TYPE" => "S",
			"MULTIPLE" => "N",
			"IBLOCK_ID" => $res			
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_FAMILY"),
			"ACTIVE" => "Y",
			"SORT" => "200",
			"CODE" => "family",
			"PROPERTY_TYPE" => "L",
			"MULTIPLE" => "N",
			"IBLOCK_ID" => $res,
			"VALUES" => Array(
				Array("VALUE" => "Продвижение нового продукта", "DEF" => "Y", "SORT" => "100"),
				Array("VALUE" => "Акция", "DEF" => "N", "SORT" => "200")
			)		
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_TYPE"),
			"ACTIVE" => "Y",
			"SORT" => "300",
			"CODE" => "type",
			"PROPERTY_TYPE" => "L",
			"IBLOCK_ID" => $res,
			"VALUES" => Array(
				Array("VALUE" => "Рассылка", "DEF" => "Y", "SORT" => "100"),
				Array("VALUE" => "Мероприятие", "DEF" => "N", "SORT" => "200")
			)			
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_SOURCE"),
			"ACTIVE" => "Y",
			"SORT" => "400",
			"CODE" => "source",
			"PROPERTY_TYPE" => "L",
			"IBLOCK_ID" => $res,
			"VALUES" => Array(
				Array("VALUE" => "Интернет", "DEF" => "Y", "SORT" => "100"),
				Array("VALUE" => "Телевидение", "DEF" => "N", "SORT" => "200")
			)			
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_RESPONSIBLE"),
			"ACTIVE" => "Y",
			"SORT" => "500",
			"CODE" => "responsible",
			"PROPERTY_TYPE" => "S",
			"USER_TYPE" => "employee",
			"IBLOCK_ID" => $res			
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_TERRITORY"),
			"ACTIVE" => "Y",
			"SORT" => "600",
			"CODE" => "territory",
			"PROPERTY_TYPE" => "S",
			"IBLOCK_ID" => $res			
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_STATUS"),
			"ACTIVE" => "Y",
			"SORT" => "700",
			"CODE" => "status",
			"PROPERTY_TYPE" => "L",
			"IBLOCK_ID" => $res,
			"VALUES" => Array(
				Array("VALUE" => "Планируется", "DEF" => "Y", "SORT" => "100"),
				Array("VALUE" => "В процессе выполнения", "DEF" => "N", "SORT" => "200"),
				Array("VALUE" => "Выполнено", "DEF" => "N", "SORT" => "300"),
				Array("VALUE" => "Отложено", "DEF" => "N", "SORT" => "400")
			)				
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_DATESTART"),
			"ACTIVE" => "Y",
			"SORT" => "900",
			"CODE" => "dateStart",
			"PROPERTY_TYPE" => "S",
			"USER_TYPE" => "DateTime",
			"IBLOCK_ID" => $res		
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_DATEFINISH"),
			"ACTIVE" => "Y",
			"SORT" => "1000",
			"CODE" => "dateFinish",
			"PROPERTY_TYPE" => "S",
			"USER_TYPE" => "DateTime",
			"IBLOCK_ID" => $res		
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_TARGETCLIENT"),
			"ACTIVE" => "Y",
			"SORT" => "1100",
			"CODE" => "targetClient",
			"PROPERTY_TYPE" => "L",
			"IBLOCK_ID" => $res,
			"VALUES" => Array(
				Array("VALUE" => "Руководители учреждений", "DEF" => "Y", "SORT" => "100"),
				Array("VALUE" => "Пользователи сайта", "DEF" => "N", "SORT" => "200")
			)				
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_COUNTOBJECT"),
			"ACTIVE" => "Y",
			"SORT" => "1200",
			"CODE" => "countObject",
			"PROPERTY_TYPE" => "N",
			"IBLOCK_ID" => $res			
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_PLANNEDRESPONSE"),
			"ACTIVE" => "Y",
			"SORT" => "1300",
			"CODE" => "plannedResponse",
			"PROPERTY_TYPE" => "N",
			"IBLOCK_ID" => $res			
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_PLANNEDBUDJET"),
			"ACTIVE" => "Y",
			"SORT" => "1400",
			"CODE" => "plannedBudget",
			"PROPERTY_TYPE" => "S",
			"IBLOCK_ID" => $res			
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_ACTUALBUDJET"),
			"ACTIVE" => "Y",
			"SORT" => "1500",
			"CODE" => "actualBudget",
			"PROPERTY_TYPE" => "S",
			"IBLOCK_ID" => $res			
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_SALESPROGRAMM"),
			"ACTIVE" => "Y",
			"SORT" => "1600",
			"CODE" => "salesProgram",
			"PROPERTY_TYPE" => "S",
			"IBLOCK_ID" => $res			
	);
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_ACTUALSALES"),
			"ACTIVE" => "Y",
			"SORT" => "1700",
			"CODE" => "actualSales",
			"PROPERTY_TYPE" => "S",
			"IBLOCK_ID" => $res			
	);
    $arFields[] = Array(
            "NAME" => GetMessage("ACTION_PROP_TEAMUSERS"),
            "ACTIVE" => "Y",
            "SORT" => "1800",
            "CODE" => "teamUsers",
            "PROPERTY_TYPE" => "S",
            "USER_TYPE" => "employee",
            "MULTIPLE" => "Y",
            "MULTIPLE_CNT" => "5",
            "IBLOCK_ID" => $res         
    );
    $arFields[] = Array(
            "NAME" => GetMessage("ACTION_PROP_TEAMCONTACTS"),
            "ACTIVE" => "Y",
            "SORT" => "1800",
            "CODE" => "teamContacts",
            "PROPERTY_TYPE" => "S",
            "MULTIPLE" => "Y",
            "MULTIPLE_CNT" => "5",
            "IBLOCK_ID" => $res         
    );
	$arFields[] = Array(
			"NAME" => GetMessage("ACTION_PROP_REVIEWS"),
			"ACTIVE" => "Y",
			"SORT" => "1800",
			"CODE" => "reviews",
			"PROPERTY_TYPE" => "E",
			"MULTIPLE" => "Y",
			"MULTIPLE_CNT" => "5",
			"LINK_IBLOCK_ID" => $reviews,
			"IBLOCK_ID" => $res			
	);
	foreach ($arFields as $arField) $ibp->Add($arField);
}

// Инфоблок выставки
/*$arFields = Array(
		"ACTIVE" => "Y",
		"NAME" => "Выставки",
		"CODE" => "exposition",
);
$res = $ib->Add($arFields);
if(!$res) echo 'Error: '.$ib->LAST_ERROR.'<br>';
else{
	$arFields = Array();
	$arFields[] = Array(
			"NAME" => "Дата проведения",
			"ACTIVE" => "Y",
			"SORT" => "100",
			"CODE" => "start_date",
			"PROPERTY_TYPE" => "S",
			"MULTIPLE" => "N",
			"USER_TYPE" => "DateTime",
			"IBLOCK_ID" => $res
	);
	$arFields[] = Array(
			"NAME" => "Дата завершения",
			"ACTIVE" => "Y",
			"SORT" => "200",
			"CODE" => "end_date",
			"PROPERTY_TYPE" => "S",
			"MULTIPLE" => "N",
			"USER_TYPE" => "DateTime",
			"IBLOCK_ID" => $res
	);
	$arFields[] = Array(
			"NAME" => "Участники",
			"ACTIVE" => "Y",
			"SORT" => "300",
			"CODE" => "participants",
			"PROPERTY_TYPE" => "N",
			"MULTIPLE" => "Y",
			"IBLOCK_ID" => $res
	);
	foreach ($arFields as $arField) $ibp->Add($arField);
}*/

echo CAdminMessage::ShowNote(GetMessage("MARKETING_INSTALL_COMPLETE"));
?>