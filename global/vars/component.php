<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Время кеширования
if (!isset($arParams["CACHE_TIME"]))
    $arParams["CACHE_TIME"] = 36000000;

// Проверка наличия кеша/кеширование
if ($this->StartResultCache($arParams["CACHE_TIME"], $arParams['CACHE_TYPE'])) {
    if (!CModule::IncludeModule("iblock")) return;
    $iblockId = $arParams["IBLOCK_ID"];
    $iblockType = $arParams["IBLOCK_TYPE"];
    $arrFilter = ["IBLOCK_ID" => $iblockId, "IBLOCK_TYPE" => $iblockType];
    // Получение свойств инфоблока
    $arResult = CIBlockElement::GetList([], $arrFilter)->GetNextElement()->GetProperties();
    $this->endResultCache();
}

//после создания данных в кеше/их получения из него
foreach ($arResult as $arItem) {
//    S - строка, N - число, F - файл, L - список, E - привязка к элементам, G - привязка к группам
    if($arItem["PROPERTY_TYPE"] == "F" && $arItem["VALUE"]) $arItem["VALUE"] = CFile::GetPath($arItem["VALUE"]);
    $GLOBALS["CONTACTS"][$arItem["CODE"]] = $arItem["VALUE"];
}
