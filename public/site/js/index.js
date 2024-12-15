let isloadIdex = 0;
$(window).on('scroll  mousemove touchstart',function(){
	try{
		if(!isloadIdex){
			isloadIdex = 1
			$(".not-dqtab").each( function(e){
				var $this1 = $(this);
				var $this2 = $(this);
				var datasection = $this1.closest('.not-dqtab').attr('data-section');
				$this1.find('.tabs-title .item:first-child').addClass('current');
				$this1.find('.tab-content').first().addClass('current');
				var _this = $(this).find('.wrap_tab_index .title_module_main');
				var droptab = $(this).find('.link_tab_check_click');
				$this1.find('.tabtitle1.ajax .item').click(function(){
					var $this2 = $(this),
						tab_id = $this2.attr('data-tab'),
						url = $this2.attr('data-url');
					var etabs = $this2.closest('.e-tabs');
					etabs.find('.tab-viewall').attr('href',url);
					etabs.find('.tabs-title .item').removeClass('current');
					etabs.find('.tab-content').removeClass('current');
					$this2.addClass('current');
					etabs.find("."+tab_id).addClass('current');
					if(!$this2.hasClass('has-content')){
						$this2.addClass('has-content');
						getContentTab(url,"."+ datasection+" ."+tab_id);
					}
				});
			});
			function getContentTab(url,selector){
				url = url+"?view=ajaxload";
				var loading = '<div class="a-center"><img src="https://bizweb.dktcdn.net/100/472/947/themes/888072/assets/rolling.svg?1671239087510" alt="loading"/></div>';
				$.ajax({
					type: 'GET',
					url: url,
					beforeSend: function() {
						$(selector).html(loading);
					},
					success: function(data) {
						var content = $(data);
						setTimeout(function(){
							$(selector).html(content.html());
							awe_lazyloadImage();

							favoriBean.Wishlist.wishlistProduct();


							$(document).ready(function () {
								var modal = $('.quickview-product');
								var btn = $('.quick-view');
								var span = $('.quickview-close');
								btn.click(function () {
									modal.show();
								});
								span.click(function () {
									modal.hide();
								});
								$(window).on('click', function (e) {
									if ($(e.target).is('.modal')) {
										modal.hide();
									}
								});
							});
						},100);
					},
					error: function(err){
						$(selector).html('<p class="a-center margin-0 padding-0">Danh mục đang cập nhật sản phẩm</p>');
					},
					dataType: "html"
				});
			}
			(function($){
				"user strict";
				$.fn.Dqdt_CountDown = function( options ) {
					return this.each(function() {
						new  $.Dqdt_CountDown( this, options );
					});
				}
				$.Dqdt_CountDown = function( obj, options ){
					this.options = $.extend({
						autoStart			: true,
						LeadingZero:true,
						DisplayFormat:"<div class=\"block-timer\"><p>%%D%%Ngày</p></div><span>:</span><div class=\"block-timer\"><p>%%H%%Giờ</p></div><span class=\"mobile\">:</span><div class=\"block-timer\"><p>%%M%%Phút</p></div><span>:</span><div class=\"block-timer\"><p>%%S%%Giây</p></div>",
						FinishMessage:"hết hạn",
						CountActive:true,
						TargetDate:null
					}, options || {} );
					if( this.options.TargetDate == null || this.options.TargetDate == '' ){
						return ;
					}
					this.timer  = null;
					this.element = obj;
					this.CountStepper = -1;
					this.CountStepper = Math.ceil(this.CountStepper);
					this.SetTimeOutPeriod = (Math.abs(this.CountStepper)-1)*1000 + 990;
					var dthen = new Date(this.options.TargetDate);
					var dnow = new Date();
					if( this.CountStepper > 0 ) {
						ddiff = new Date(dnow-dthen);
					}
					else {
						ddiff = new Date(dthen-dnow);
					}
					gsecs = Math.floor(ddiff.valueOf()/1000);
					this.CountBack(gsecs, this);
				};
				$.Dqdt_CountDown.fn =  $.Dqdt_CountDown.prototype;
				$.Dqdt_CountDown.fn.extend =  $.Dqdt_CountDown.extend = $.extend;
				$.Dqdt_CountDown.fn.extend({
					calculateDate:function( secs, num1, num2 ){
						var s = ((Math.floor(secs/num1))%num2).toString();
						if ( this.options.LeadingZero && s.length < 2) {
							s = "0" + s;
						}
						return "<b>" + s + "</b>";
					},
					CountBack:function( secs, self ){
						if (secs < 0) {
							self.element.innerHTML = '<div class="lof-labelexpired"> '+self.options.FinishMessage+"</div>";
							return;
						}
						clearInterval(self.timer);
						DisplayStr = self.options.DisplayFormat.replace(/%%D%%/g, self.calculateDate( secs,86400,365) );
						DisplayStr = DisplayStr.replace(/%%H%%/g, self.calculateDate(secs,3600,24));
						DisplayStr = DisplayStr.replace(/%%M%%/g, self.calculateDate(secs,60,60));
						DisplayStr = DisplayStr.replace(/%%S%%/g, self.calculateDate(secs,1,60));
						self.element.innerHTML = DisplayStr;
						if (self.options.CountActive) {
							self.timer = null;
							self.timer =  setTimeout( function(){
								self.CountBack((secs+self.CountStepper),self);
							},( self.SetTimeOutPeriod ) );
						}
					}
				});
				$(document).ready(function(){
					$('[data-countdown="countdown"]').each(function(index, el) {
						var $this = $(this);
						var $date = $this.data('date').split("-");
						$this.Dqdt_CountDown({
							TargetDate:$date[0]+"/"+$date[1]+"/"+$date[2]+" "+$date[3]+":"+$date[4]+":"+$date[5],
							DisplayFormat:"<div class=\"block-timer\"><p>%%D%%Ngày</p></div><span>:</span><div class=\"block-timer\"><p>%%H%%Giờ</p></div><span class=\"mobile\">:</span><div class=\"block-timer\"><p>%%M%%Phút</p></div><span>:</span><div class=\"block-timer\"><p>%%S%%Giây</p></div>",
							FinishMessage: "Chương trình đã hết hạn"
						});
					});
				});
			})(jQuery);
		}
	}catch(e){
		console.log(e);
	}
});
