<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/**
 * @var string $componentPath
 * @var string $componentName
 * @var array $arCurrentValues
 * */

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock')) return;


$arTypesEx = CIBlockParameters::GetIBlockTypes();

$arIBlocks = [];
$iblockFilter = [
    'ACTIVE' => 'Y',
];
if (!empty($arCurrentValues['IBLOCK_TYPE']))
{
    $iblockFilter['TYPE'] = $arCurrentValues['IBLOCK_TYPE'];
}
if (isset($_REQUEST['site']))
{
    $iblockFilter['SITE_ID'] = $_REQUEST['site'];
}
$db_iblock = CIBlock::GetList(["SORT"=>"ASC"], $iblockFilter);
while($arRes = $db_iblock->Fetch())
{
    $arIBlocks[$arRes["ID"]] = "[" . $arRes["ID"] . "] " . $arRes["NAME"];
}

$arComponentParameters = [
    "PARAMETERS" => [
        "IBLOCK_TYPE" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBLOCK_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arTypesEx,
            "DEFAULT" => "Content",
            "REFRESH" => "Y",
        ],
        "IBLOCK_ID" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBLOCK"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "DEFAULT" => '={$_REQUEST["ID"]}',
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "Y",
        ],
        "ELEMENT" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("ELEMENT"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "Y",
        ],
        "CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
    ]
];
