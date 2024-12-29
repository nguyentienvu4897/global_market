window.awe = window.awe || {};
awe.init = function () {
	awe.showPopup();
	awe.hidePopup();
};
$(document).ready(function ($) {
	"use strict";
	awe_backtotop();
	awe_tab();
	$('#icon-menu-bar').click(function() {
		$(".menu-svg").toggleClass("hidden");
		$(".close-svg").toggleClass("show-menu");
		$(this).toggleClass('open');
		$('.top-search').slideToggle();
	});
});
$('.dropdown-toggle').click(function() {
	$(this).parent().toggleClass('open');
});
$('.close-pop').click(function() {
	$('#popup-cart').removeClass('opencart');
	$('body').removeClass('opacitycart');
});
$('.backdrop__body-backdrop___1rvky').click(function(){
	$('.header').removeClass('current');
	$('#popup-cart').removeClass('opencart');
	$('body').removeClass('opacitycart');
	$('.popup-coupon, .backdrop__body-backdrop___1rvky').removeClass('active');
});
$(document).on('click','.overlay, .close-popup, .btn-continue, .fancybox-close', function() {
	hidePopup('.awe-popup');
	setTimeout(function(){
		$('.loading').removeClass('loaded-content');
	},500);
	return false;
})
function awe_showLoading(selector) {
	var loading = $('.loader').html();
	$(selector).addClass("loading").append(loading);
}  window.awe_showLoading=awe_showLoading;
function awe_hideLoading(selector) {
	$(selector).removeClass("loading");
	$(selector + ' .loading-icon').remove();
}  window.awe_hideLoading=awe_hideLoading;
function awe_showPopup(selector) {
	$(selector).addClass('active');
}  window.awe_showPopup=awe_showPopup;
function awe_hidePopup(selector) {
	$(selector).removeClass('active');
}  window.awe_hidePopup=awe_hidePopup;
awe.hidePopup = function (selector) {
	$(selector).removeClass('active');
}
$(document).on('click','.overlay, .close-window, .btn-continue, .fancybox-close', function() {
	awe.hidePopup('.awe-popup');
	setTimeout(function(){
		$('.loading').removeClass('loaded-content');
	},500);
	return false;
})
var wDWs = $(window).width();

if (wDWs < 1199) {
	$('.quickview-product').remove();
}

if (wDWs < 767) {
	$('.footer-click h4').click(function(e){
		$(this).toggleClass('cls_mn').next().slideToggle();
		$(this).next('ul').toggleClass("current");
	});
}
if (wDWs > 1025) {
	$(document).ready(function ($) {
		$('.header-mid-mobile').html('');
	});
}
if (wDWs < 1025) {
	$(document).ready(function ($) {
	});
	$('.menu-bar').on('click', function(){
		$('.opacity_menu').addClass('current');
	})
	$('#nav li .open_mnu, #nav_mob li .open_mnu, #nav-mobile li .open_mnu').click(function(e){
		if($(this).hasClass('current')) {
			$(this).closest('ul').find('li, .open_mnu').removeClass('current');
		} else {
			$(this).closest('ul').find('li, .open_mnu').removeClass('current');
			$(this).closest('li').addClass('current');
			$(this).addClass('current');
		}
	});
	$('.opacity_menu').on('click', function(){
		$('.opacity_menu').removeClass('current');
	})
	$('.header-action-item.search-mobile').click(function(e){
		e.preventDefault();
		$('.search-mobile.search_form').toggleClass('open');
	});
	$('.input-group-btn .search-close').click(function(e){
		e.preventDefault();
		$('.search-mobile.search_form').toggleClass('open');
	});
	$('#btn-menu-mobile').on('click', function(){
		$('.header').addClass('current');
		$(".backdrop__body-backdrop___1rvky").addClass('active');
	});
	$('.title_menu').on('click', function(){
		$(this).closest('.header').removeClass('current');
		$(".backdrop__body-backdrop___1rvky").removeClass('active');
	});

}
function awe_convertVietnamese(str) {
	str= str.toLowerCase();
	str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
	str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
	str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
	str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
	str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
	str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
	str= str.replace(/đ/g,"d");
	str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
	str= str.replace(/-+-/g,"-");
	str= str.replace(/^\-+|\-+$/g,"");
	return str;
} window.awe_convertVietnamese=awe_convertVietnamese;
function awe_backtotop() {
	$(window).scroll(function() {
		$(this).scrollTop() > 200 ? $('.backtop').addClass('show') : $('.backtop').removeClass('show')
	});
	$('.backtop').click(function() {
		return $("body,html").animate({
			scrollTop: 0
		}, 800), !1
	});
} window.awe_backtotop=awe_backtotop;
function awe_tab() {
	$(".e-tabs:not(.not-dqtab)").each( function(){
		$(this).find('.tabs-title li:first-child').addClass('current');
		$(this).find('.tab-content').first().addClass('current');
		$(this).find('.tabs-title li').click(function(e){
			var tab_id = $(this).attr('data-tab');
			var url = $(this).attr('data-url');
			$(this).closest('.e-tabs').find('.tab-viewall').attr('href',url);
			$(this).closest('.e-tabs').find('.tabs-title li').removeClass('current');
			$(this).closest('.e-tabs').find('.tab-content').removeClass('current');
			$(this).addClass('current');
			$(this).closest('.e-tabs').find("#"+tab_id).addClass('current');

		});
	});
} window.awe_tab=awe_tab;
$('.dropdown-toggle').click(function() {
	$(this).parent().toggleClass('open');
});
$('.btn-close').click(function() {
	$(this).parents('.dropdown').toggleClass('open');
});
$(document).on('keydown','#qty, .number-sidebar',function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
$(document).on('click','.qtyplus',function(e){
	e.preventDefault();
	fieldName = $(this).attr('data-field');
	var currentVal = parseInt($('input[data-field='+fieldName+']').val());
	if (!isNaN(currentVal)) {
		$('input[data-field='+fieldName+']').val(currentVal + 1);
	} else {
		$('input[data-field='+fieldName+']').val(0);
	}
});
$(document).on('click','.qtyminus',function(e){
	e.preventDefault();
	fieldName = $(this).attr('data-field');
	var currentVal = parseInt($('input[data-field='+fieldName+']').val());
	if (!isNaN(currentVal) && currentVal > 1) {
		$('input[data-field='+fieldName+']').val(currentVal - 1);
	} else {
		$('input[data-field='+fieldName+']').val(1);
	}
});
$('.opacity_sidebar').click(function(e){
	$('.opacity_sidebar').removeClass('openf');
	$('.dqdt-sidebar, .aside-filter').removeClass('openf')
});
$('.opacity_menu').click(function(e){
	$('.wrapmenu_right').removeClass('open_sidebar_menu');
	$('.opacity_menu').removeClass('open_opacity');
});
$(".menubar_pc").click(function(){
	$('.wrapmenu_full').slideToggle('fast');
	$('.wrapmenu_full, .cloed').toggleClass('open_menu');
	$('.dqdt-sidebar, .aside-filter').removeClass('openf')
});
$(".cloed").click(function(){
	$(this).toggleClass('open_menu');
	$('.wrapmenu_full').slideToggle('fast');
});
$(".opacity_menu").click(function(){
	$('.opacity_menu').removeClass('open_opacity');
});
if ($('.dqdt-sidebar, .aside-filter').hasClass('openf')) {
	$('.wrapmenu_full').removeClass('open_menu');
}
$('.ul_collections li > svg').click(function(){
	$(this).parent().toggleClass('current');
	$(this).toggleClass('fa-angle-down fa-angle-right');
	$(this).next('ul').slideToggle("fast");
	$(this).next('div').slideToggle("fast");
});
$('.searchion').mouseover(function() {
	$('.searchmini input').focus();
})
$('.quenmk').on('click', function() {
	$('#login').toggleClass('hidden');
	$('.h_recover').slideToggle();
});
$('a[data-toggle="collapse"]').click(function(e){
	if ($(window).width() >= 767) {
		e.preventDefault();
		e.stopPropagation();
	}
});
$('body').click(function(event) {
	if (!$(event.target).closest('.collection-selector').length) {
		$('.list_search').css('display','none');
	};
});
$('.search_text').click(function(){
	$(this).next().slideToggle(200);
	$('.list_search').show();
});
$('.list_search .search_item').on('click', function (e) {
	$('.list_search').hide();
	var optionSelected = $(this);
	var title = optionSelected.text();
	$('.search_text').text(title);
	$(".search-text").focus();
	optionSelected.addClass('active').siblings().removeClass('active');
});
$('.header_search form button').click(function(e) {
	e.preventDefault();
	var textmm = $('.search-text').val();
	if (textmm != '') {
		searchCollection();
		setSearchStorage('.header_search form');
	} else {
		alert('bạn chưa nhập nội dung tìm kiếm');
	}
});
$('#mb_search').click(function(){
	$('.mb_header_search').slideToggle('fast');
});
$('.fi-title.drop-down').click(function(){
	$(this).toggleClass('opentab');
});
function searchCollection() {
	var collectionId = $('.list_search .search_item.active').attr('data-coll-id');
	var vl = $('.header form input').val();
	var searchVal = $('.header_search input[type="search"]').val();
	var url = '';
	if(collectionId == 0 || vl == '') {
		url = '/search?q='+ searchVal;
	}else {
		url = '/search?q=collections:'+ collectionId +' AND name:' + searchVal;
	}
	window.location=url;
}
function setSearchStorage(form_id) {
	var seach_input = $(form_id).find('.search-text').val();
	var search_collection = $(form_id).find('.list_search .search_item.active').attr('data-coll-id');
	sessionStorage.setItem('search_input', seach_input);
	sessionStorage.setItem('search_collection', search_collection);
}
function getSearchStorage(form_id) {
	var search_input_st = '';
	var search_collection_st = '';
	if(sessionStorage.search_input != '') {
		search_input_st = sessionStorage.search_input;
	}
	if(sessionStorage.search_collection != '') {
		search_collection_st = sessionStorage.search_collection;
	}
	$(form_id).find('.search-text').val(search_input_st);
	$(form_id).find('.search_item[data-coll-id="'+search_collection_st+'"]').addClass('active').siblings().removeClass('active');
	var search_key = $(form_id).find('.search_item[data-coll-id="'+search_collection_st+'"]').text();
	if(search_key != ''){
		var searchVal = $('.header_search input[type="search"]').val();
		$(form_id).find('.collection-selector .search_text').text(search_key);
		$('.search_item_name').text(searchVal + " thuộc danh mục " + search_key);
	}
}
function resetSearchStorage() {
	sessionStorage.removeItem('search_input');
	sessionStorage.removeItem('search_collection');
}
$(window).load(function() {
	getSearchStorage('.header_search form');
	resetSearchStorage();
});
$('.xemthem').click(function(e){
	e.preventDefault();
	$('ul.ul_menu>li').css('display','block');
	$(this).hide();
	$('.thugon').show();
})
$('.thugon').click(function(e){
	e.preventDefault();
	$('ul.ul_menu>li').css('display','none');
	$(this).hide();
	$('.xemthem').show();
})
$('.ul_menu .lev-1').click(function(e){
	var lil = $('.ul_menu .lev-1').length;
	var divHeight = $('.list_menu_header').height();
	if(lil = 2){
		$('.ul_menu .ul_content_right_1').css('min-height', divHeight);
	}
});
window.onload = function(e){
	var lil = $('.ul_menu .lev-1').length;
	var vw = $(window).width();
	if(lil < 9 && vw < 1500 && vw > 1200){
		$('li.hidden-lgg').remove();
	}
}
if (wDWs > 992) {
	function horizontalNav() {
		return {
			wrapper: $('.navigation-horizontal'),
			navigation: $('.navigation-horizontal .nav'),
			item: $('.navigation-horizontal .nav .nav-item'),
			totalStep: 0,
			onCalcNavOverView: function(){
				let itemHeight = this.item.eq(0).outerWidth(),
					lilength = this.item.length,
					total = 0;
				for (var i = 0; i < lilength; i++) {
					itemHeight = this.item.eq(i).outerWidth();
					total += itemHeight;
				}
				return Math.ceil(total)
			},
			onCalcTotal: function(){
				let  navHeight = this.navigation.width();
				return Math.ceil(navHeight)
			},
			init:function(){
				this.totalStep = this.onCalcNavOverView();
				this.totalTo = this.onCalcTotal();
				if(this.totalStep > this.totalTo){
					this.wrapper.addClass('overflow')
				}
			}
		}
	}

    // create sticky menu
	// $( document ).scroll(function(){
	// 	var scroll	=	$(window).scrollTop();
	// 	/* set sticky menu */
	// 	if( scroll >= 105){
	// 		$(".menu_mega").addClass("pos_active");
	// 	}else{
	// 		$(".menu_mega").removeClass("pos_active");
	// 	}
	// });
}
$(document).ready(function ($) {
	if(window.matchMedia('(min-width: 992px)').matches){
		horizontalNav().init()
		$(window).on('resize',()=>horizontalNav().init())
		var margin_left = 0;
		$('#prev').on('click', function(e) {
			e.preventDefault();
			animateMargin(190);
		});
		$('#next').on('click', function(e) {
			e.preventDefault();
			animateMargin(-190);
		});
		const animateMargin = ( amount ) => {
			margin_left = Math.min(0, Math.max( getMaxMargin(), margin_left + amount ));
			$('ul.nav').animate({
				'margin-left': margin_left
			}, 300);
		};
		const getMaxMargin = () =>
		$('ul.nav').parent().width() - $('ul.nav')[0].scrollWidth;
	}
});

$(document).ready(function(){
	$('.header_tim_kiem .search-bar input.input-group-field, .search-mobile .search-bar input.input-group-field').focus(function(eventClick) {
		eventClick.stopPropagation();
		$('.search-suggest').addClass('open');
		$(this).parent().addClass('active');
	});
	$(document).click( function(eventClick){
		if ( !$(eventClick.target).closest('.header_tim_kiem .search-bar, .search-mobile .search-bar').length ) {
			$('.search-suggest').removeClass('open');
			$('.box-search').removeClass('active');
		}
	});
});


// $(document).ready(function(){
// 	function getItemSearch(name, smartjson){
// 		return fetch(`https://${window.location.hostname}/search?q=${name}&view=${smartjson}&type=product`)
// 			.then(res => res.json())
// 			.catch(err => console.error(err))
// 	}
// 	$('.header_tim_kiem input[type="text"], .search-mobile input[type="text"]').bind('keyup change', function(e){
// 		let term = $(this).val().trim();
// 		let data = '';
// 		var resultbox = '';
// 		if(term.length > 1) {
// 			$('.title_no_mis').html('ĐỀ XUẤT TÌM KIẾM');
// 			$('.search-list').addClass('no-mis');
// 			async function goawaySearch() {
// 				data = await getItemSearch(term, 'smartjson');
// 				setTimeout(function(){
// 					var sizeData = Object.keys(data).length;
// 					if(sizeData > 0) {
// 						Object.keys(data).forEach(function(key) {
// 							if (data[key].compare_price != 0 ) {
// 								resultbox += `<div class="product-smart"><a class="image_thumb" href="${data[key].url}" title="${data[key].name}"><img width="480" height="480" class="lazyload loaded" src="${data[key].image}" data-src="${data[key].image}" alt="${data[key].name}"></a><div class="product-info"><a class="product-name" href="${data[key].url}" title="${data[key].name}">${data[key].name}</a><span class="price">${data[key].price}</span><span class="compare-price">${data[key].compare_price}</span></div></div>`
// 							} else {
// 								resultbox += `<div class="product-smart"><a class="image_thumb" href="${data[key].url}" title="${data[key].name}"><img width="480" height="480" class="lazyload loaded" src="${data[key].image}" data-src="${data[key].image}" alt="${data[key].name}"></a><div class="product-info"><a class="product-name" href="${data[key].url}" title="${data[key].name}">${data[key].name}</a><span class="price">${data[key].price}</span></div></div>`
// 							}
// 						});
// 						resultbox +=`<a href="/search?query=${term}&type=product" class="see-all-search" title="Xem tất cả">Xem tất cả</a>`
// 						$('.list-search').html(resultbox);
// 					} else {
// 						$('.list-search').html('<div class="not-pro">Không có thấy kết quả tìm kiếm</div>');
// 					}
// 				}, 200);
// 			}
// 			goawaySearch();
// 		}else {
// 			$('.title_no_mis').html('SẢN PHẨM ĐỀ XUẤT');
// 									$('.list-search').html('');
// 			$('.search-list').removeClass('no-mis');
// 		}
// 	});
// });

// theme.alert = (function() {
// 	var $alert = $('#js-global-alert'),
// 		$title = $('#js-global-alert .alert-heading'),
// 		$content = $('#js-global-alert .alert-content'),
// 		close = '#js-global-alert .close';
// 	var timeoutID = null;
// 	$(document).on('click', close, function() {
// 		$alert.removeClass('active');
// 	});

// 	function createAlert(title, mess, time, type) {
// 		var alertTitle = title || '',
// 			showTime = time || 3000,
// 			alertClass = type;

// 		$alert.removeClass('alert-success').removeClass('alert-danger').removeClass('alert-warning').removeClass('alert-primary');
// 		$alert.addClass(alertClass);
// 		$title.html(title);
// 		$content.html(mess);
// 		$alert.addClass('active');
// 		if (timeoutID) {
// 			clearTimeout(timeoutID);
// 		}

// 		timeoutID = setTimeout(function() {
// 			$alert.removeClass('active');
// 		}, showTime);
// 	}

// 	return {
// 		new: createAlert
// 	};
// })();
if($(window).width() > 991) {
	(function() {

		var quotes = $(".quotes");
		var quoteIndex = -1;

		function showNextQuote() {
			++quoteIndex;
			quotes.eq(quoteIndex % quotes.length)
				.fadeIn(500)
				.delay(4000)
				.fadeOut(500, showNextQuote);
		}

		showNextQuote();

	})();
}
$('.ul_menu .nav_item.lv1 .box-menu svg').click(function() {
	$(this).toggleClass('active').next().slideToggle();
	$(this).parent().toggleClass('active');
});
