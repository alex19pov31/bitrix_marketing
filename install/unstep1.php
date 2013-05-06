<?php
if(!check_bitrix_sessid()) return;
/*$obBlocktype = new CIBlockType;
$ib = new CIBlock;
$ibp = new CIBlockProperty;*/


echo CAdminMessage::ShowNote(GetMessage("MARKETING_UNINSTALL_COMPLETE"));
?>