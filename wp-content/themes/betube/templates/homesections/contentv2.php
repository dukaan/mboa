<?php 
global $redux_demo;
/*First Section */
$betubeFirstSecON = $redux_demo['landing-first-section-on'];
$betubeFirstSecTitle = $redux_demo['landing-first-section-title'];
$betubeFirstSecView = $redux_demo['landing-first-grid-selection'];
$betubeFirstSecCategory = $redux_demo['landing-first-section-category'];
$betubeFirstSecCount = $redux_demo['landing-first-section-pcount'];
$betubeFirstSecOrder = $redux_demo['landing-first-section-order'];
$betubeFirstSecAds = $redux_demo['landing-first-section-ad_code'];
/*Second Section */
$betubeSecondSecON = $redux_demo['landing-second-section-on'];
$betubeSecondSecTitle = $redux_demo['landing-second-section-title'];
$betubeSecondSecView = $redux_demo['landing-second-grid-selection'];
$betubeSecondSecCategory = $redux_demo['landing-second-section-category'];
$betubeSecondSecCount = $redux_demo['landing-second-section-pcount'];
$betubeSecondSecOrder = $redux_demo['landing-second-section-order'];
$betubeSecondSecAds = $redux_demo['landing-second-section-ad_code'];
/*Third Section */
$betubeThirdSecON = $redux_demo['landing-third-section-on'];
$betubeThirdSecTitle = $redux_demo['landing-third-section-title'];
$betubeThirdSecView = $redux_demo['landing-third-grid-selection'];
$betubeThirdSecCategory = $redux_demo['landing-third-section-category'];
$betubeThirdSecCount = $redux_demo['landing-third-section-pcount'];
$betubeThirdSecOrder = $redux_demo['landing-third-section-order'];
$betubeThirdSecAds = $redux_demo['landing-third-section-ad_code'];
/*Fourth Section */
$betubeFourthSecON = $redux_demo['landing-fourth-section-on'];
$betubeFourthSecTitle = $redux_demo['landing-fourth-section-title'];
$betubeFourthSecView = $redux_demo['landing-fourth-grid-selection'];
$betubeFourthSecCategory = $redux_demo['landing-fourth-section-category'];
$betubeFourthSecCount = $redux_demo['landing-fourth-section-pcount'];
$betubeFourthSecOrder = $redux_demo['landing-fourth-section-order'];
$betubeFourthSecAds = $redux_demo['landing-fourth-section-ad_code'];
/*Five Section */
$betubeFiveSecON = $redux_demo['landing-five-section-on'];
$betubeFiveSecTitle = $redux_demo['landing-five-section-title'];
$betubeFiveSecView = $redux_demo['landing-five-grid-selection'];
$betubeFiveSecCategory = $redux_demo['landing-five-section-category'];
$betubeFiveSecCount = $redux_demo['landing-five-section-pcount'];
$betubeFiveSecOrder = $redux_demo['landing-five-section-order'];
$betubeFiveSecAds = $redux_demo['landing-five-section-ad_code'];
?>
<div class="row">
	<div class="large-8 columns">
<?php
	/*First Section*/
	if($betubeFirstSecON == 1){
		$sectionTitle = $betubeFirstSecTitle;
		$sectionCategory = $betubeFirstSecCategory;
		$sectionView = $betubeFirstSecView;
		$sectionCount = $betubeFirstSecCount;
		$sectionOrder = $betubeFirstSecOrder;
		$sectionAdsCode = $betubeFirstSecAds;
		beTubeGetHomeContent($sectionTitle, $sectionCategory, $sectionView, $sectionCount, $sectionOrder, $sectionAdsCode);
	}
	/*Second Section*/
	if($betubeSecondSecON == 1){
		$sectionTitle = $betubeSecondSecTitle;
		$sectionCategory = $betubeSecondSecCategory;
		$sectionView = $betubeSecondSecView;
		$sectionCount = $betubeSecondSecCount;
		$sectionOrder = $betubeSecondSecOrder;
		$sectionAdsCode = $betubeSecondSecAds;
		beTubeGetHomeContent($sectionTitle, $sectionCategory, $sectionView, $sectionCount, $sectionOrder, $sectionAdsCode);
	}
	/*Third Section*/
	if($betubeThirdSecON == 1){
		$sectionTitle = $betubeThirdSecTitle;
		$sectionCategory = $betubeThirdSecCategory;
		$sectionView = $betubeThirdSecView;
		$sectionCount = $betubeThirdSecCount;
		$sectionOrder = $betubeThirdSecOrder;
		$sectionAdsCode = $betubeThirdSecAds;
		beTubeGetHomeContent($sectionTitle, $sectionCategory, $sectionView, $sectionCount, $sectionOrder, $sectionAdsCode);
	}
	/*Fourth Section*/
	if($betubeFourthSecON == 1){
		$sectionTitle = $betubeFourthSecTitle;
		$sectionCategory = $betubeFourthSecCategory;
		$sectionView = $betubeFourthSecView;
		$sectionCount = $betubeFourthSecCount;
		$sectionOrder = $betubeFourthSecOrder;
		$sectionAdsCode = $betubeFourthSecAds;
		beTubeGetHomeContent($sectionTitle, $sectionCategory, $sectionView, $sectionCount, $sectionOrder, $sectionAdsCode);
	}
	/*Fifth Section*/
	if($betubeFiveSecON == 1){
		$sectionTitle = $betubeFiveSecTitle;
		$sectionCategory = $betubeFiveSecCategory;
		$sectionView = $betubeFiveSecView;
		$sectionCount = $betubeFiveSecCount;
		$sectionOrder = $betubeFiveSecOrder;
		$sectionAdsCode = $betubeFiveSecAds;
		beTubeGetHomeContent($sectionTitle, $sectionCategory, $sectionView, $sectionCount, $sectionOrder, $sectionAdsCode);
	}
?>
	</div><!--End Large8-->
	<div class="large-4 columns">
		<aside class="secBg sidebar">
			<div class="row">
			<?php dynamic_sidebar( 'main' ); ?>
			</div>
		</aside>
	</div>
</div>