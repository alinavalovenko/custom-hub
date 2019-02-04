jQuery(document).ready(function ($) {
    var hubSliderList = $('.hubcategory-slider');
    var hubSlider = $('.hubcategory-slider div.hubpost-card-slide');
    hubSliderList.slick({
        infinite: true,
        dots: true,
        speed: 500,
        slidesToShow: 1,
        adaptiveHeight: true,
    });
});
