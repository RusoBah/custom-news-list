<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");?><!-- About Section --><section class="page-section bg-primary" id="home">

  <h1>Новости</h1>
  <?php 
      use Bitrix\Main\UI\Filter\Options;
      \Bitrix\Main\Loader::includeModule('main');
      $filterId = "news_filter";
      $filterOptions = new Options($filterId);
      $filterData = $filterOptions->getFilter([]);
        
      // $filterPrefix = "news_filter";

      // массив фильтра для компонента news.list
      $news_filter = [];

      // Обработка фильтра по названию (поиск по подстроке)
      if (!empty($filterData['NAME'])) {
          $news_filter['%NAME'] = $filterData['NAME'];
      }

      if (!empty($filterData['ACTIVE_FROM'])) {
        $date = DateTime::createFromFormat('d.m.Y', $filterData['ACTIVE_FROM']);
        if ($date) {
          $news_filter['>=DATE_ACTIVE_FROM'] = $date->format('Y-m-d 00:00:00');
        }
      }

      if (!empty($filterData['ACTIVE'])) {
          if (is_array($filterData['ACTIVE'])) {
              if (count($filterData['ACTIVE']) === 1) {
                  $news_filter['ACTIVE'] = $filterData['ACTIVE'][0];
              } else {
                  $news_filter['ACTIVE'] = $filterData['ACTIVE'];
              }
          } else {
              $news_filter['ACTIVE'] = $filterData['ACTIVE'];
          }
      }

      /* Фильтр */

      $APPLICATION->IncludeComponent(
        "bitrix:main.ui.filter",
        "",
        array(
            "FILTER_ID" => $filterId,
            "FILTER" => array(
                array(
                    "id" => "NAME",
                    "name" => "Название",
                    "type" => "string",
                ),
                array(
                    "id" => "ACTIVE_FROM",
                    "name" => "Дата публикации",
                    "type" => "date",
                ),
                array(
                    "id" => "ACTIVE",
                    "name" => "Активность",
                    "type" => "list",
                    "items" => array(
                        "Y" => "Активно",
                        "N" => "Неактивно"
                    ),
                    "params" => array(
                        "multiple" => "Y"
                    ),
                ),
            ),
            "ENABLE_FIELDS_SEARCH" => true,
            "ENABLE_LABEL" => true,
            "ENABLE_LIVE_SEARCH" => true,
        )
    );
    ?>
<section class="page-section bg-primary" id="home"> 

    
    <?
    /* Компонент новостей */

    $APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "bootstrap_v4",
    array(
        "IBLOCK_TYPE" => "news",
        "IBLOCK_ID" => "162",
        "NEWS_COUNT" => "5",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "SORT",
        "SORT_ORDER2" => "ASC",
        "FILTER_NAME" => $filterId,
        "FIELD_CODE" => array("ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DATE_ACTIVE_FROM"),
        "PROPERTY_CODE" => array("ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DATE_ACTIVE_FROM"),
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "AJAX_MODE" => "Y",
        "AJAX_OPTION_SHADOW" => "Y",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "PREVIEW_TRUNCATE_LEN" => "100",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "DISPLAY_PANEL" => "N",
        "SET_TITLE" => "N",
        "SET_STATUS_404" => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "Новости",
        "PAGER_SHOW_ALWAYS" => "Y",
        "PAGER_TEMPLATE" => "bootstrap_v4",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
        "PAGER_SHOW_ALL" => "Y",
        "AJAX_OPTION_ADDITIONAL" => ""
    ),
    false
    );
    
    ?>



</section>
    

<br>
 </section>
<br>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
