<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin.php');
use Silversite\Toolkit\Catalog\SilverSiteCatalog;
use Silversite\Toolkit\updateSortIndex;

$arCatalogParams = SilverSiteCatalog::getCatalogParams();
//tdump($arCatalogParams);

$obSortIndex = new updateSortIndex();
$arProducts = $obSortIndex->getProductsArray();
//tdump($arProducts);
ob_start();
?>
<scirpt src="/local/templates/silversite/js/sst-toolkit.js"></scirpt>
<?php
$c = ob_get_contents();
ob_end_clean();
\Bitrix\Main\Page\Asset::getInstance()->addString($c);
?>
<div class="adm-detail-content">
	<div class="adm-detail-content-wrap">

		<form action="<?echo $APPLICATION->GetCurPage()?>?lang=<?=LANG?>" method="get">
			<div class="adm-detail-content-item-block">
				<table class="adm-detail-content-table edit-table">
					<tr class="heading">
						<td colspan="2"><b>Настройка перерасчета значений свойств</b></td>
					</tr>
					<tr>
						<td class="adm-detail-content-cell-l">Торговый каталог</td>
						<td>
							<select name="catalog-iblock-id" id="catalog-iblock-id">
								<?php foreach($arCatalogParams as $arCatParams):?>
									<option value="<?php echo $arCatParams["catalogParams"]["IBLOCK_ID"];?>"<?if((int) $_GET["catalog-iblock-id"] == $arCatParams["catalogParams"]["IBLOCK_ID"]) echo " selected";?>><?php echo $arCatParams["catalogParams"]["IBLOCK_TYPE"];?></option>
								<?php endforeach;?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="adm-detail-content-cell-l">Промежуточное значение цены</td>
						<td>
							<input type="text" name="ipv" placeholder="от <?php echo current($arProducts["SORT_ARRAY"]);?> до <?php echo end($arProducts["SORT_ARRAY"]);?>">
						</td>
					</tr>
					<tr>
						<td class="adm-detail-content-cell-l">Левая граница, %</td>
						<td>
							<input type="text" name="ll">
						</td>
					</tr>
					<tr>
						<td class="adm-detail-content-cell-l">Правая граница, %</td>
						<td>
							<input type="text" name="rl">
						</td>
					</tr>
				</table>
				<input type="submit" name="apply" value="Применить" class="adm-btn-save">
			</div>
		</form>

	</div>
</div>
<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_admin.php');
?>