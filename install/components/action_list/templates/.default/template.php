<!-- HTML шаблон компонента -->

<?php 

//покажем панель с кнопками
$APPLICATION->IncludeComponent(
		"bitrix:main.interface.toolbar",
		"",
		array(
				"BUTTONS"=>array(
                        array(
                                "TEXT"=>"Добавить воздействие",
                                "TITLE"=>"Добавить воздействие",
                                "LINK"=>$arParams["EDIT_URL"],//$APPLICATION->GetCurPage(),
                                "ICON"=>"btn-new",
                        ),
                        array(
                                "TEXT"=>"Экспорт в CSV",
                                "TITLE"=>"Экспорт в CSV",
                                "LINK"=>$APPLICATION->GetCurPage().'?import',
                                "ICON"=>"btn-excel",
                        ),
						/*array("SEPARATOR"=>true),
						array(
								"TEXT"=>"Скопировать админа",
								"TITLE"=>"Скопировать пользователя номер 1",
								"LINK"=>"/bitrix/admin/user_edit.php?COPY_ID=1",
								"ICON"=>"btn-copy",
						),
						array(
								"TEXT"=>"Скопировать себя",
								"TITLE"=>"Скопировать пользователя номер 1",
								"LINK"=>"/bitrix/admin/user_edit.php?COPY_ID=".$GLOBALS["USER"]->GetID(),
								"ICON"=>"btn-copy",
						),
						array("NEWBAR"=>true),
						array(
								"TEXT"=>"Добавить",
								"TITLE"=>"Добавить пользователя или группу",
								"MENU"=>array(
										array("ICONCLASS"=>"add", "TEXT"=>"Пользователя", "ONCLICK"=>"jsUtils.Redirect(arguments, '/bitrix/admin/user_edit.php')"),
										array("ICONCLASS"=>"add", "TEXT"=>"Группу пользователей", "ONCLICK"=>"jsUtils.Redirect(arguments, '/bitrix/admin/group_edit.php')"),
								),
								"ICON"=>"btn-new",
				),*/
				),
),
$component
);



$APPLICATION->IncludeComponent(
		'bitrix:main.interface.grid',
		'',
		array(
				'GRID_ID' => $arResult["GRID_ID"],
				'HEADERS' => $arResult["HEADERS"],
				'SORT' => $arResult['SORT'],
				'SORT_VARS' => $arResult['SORT_VARS'],
				'ROWS' => $arResult['ROWS'],
				'FOOTER' => $arParams['~FOOTER'],
				'EDITABLE' => $arParams['~EDITABLE'],
				'ACTIONS' => $arParams['~ACTIONS'],
				'ACTION_ALL_ROWS' => $arParams['~ACTION_ALL_ROWS'],
				'NAV_OBJECT' => $db_res,
				'FORM_ID' => $arParams['~FORM_ID'],
				'TAB_ID' => $arParams['~TAB_ID'],
				'AJAX_MODE' => $arParams['~AJAX_MODE'],
				'AJAX_ID' => isset($arParams['~AJAX_ID']) ? $arParams['~AJAX_ID'] : '',
				'AJAX_OPTION_JUMP' => isset($arParams['~AJAX_OPTION_JUMP']) ? $arParams['~AJAX_OPTION_JUMP'] : 'N',
				'AJAX_OPTION_HISTORY' => isset($arParams['~AJAX_OPTION_HISTORY']) ? $arParams['~AJAX_OPTION_HISTORY'] : 'N',
				'AJAX_INIT_EVENT' => isset($arParams['~AJAX_INIT_EVENT']) ? $arParams['~AJAX_INIT_EVENT'] : '',
				'FILTER' => $arResult["FILTER"],
				'FILTER_PRESETS' => $arParams['~FILTER_PRESETS']
		),
		$component, array('HIDE_ICONS' => 'Y')
);
?>