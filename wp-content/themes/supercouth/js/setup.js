( function( $ ) {

	$( document ).ready( documentReadyFunction );
	$( window ).load( documentLoadFunction );
	$( window ).resize( windowResizeFunction );
	$( window ).scroll( windowScrollFunction );


	var msnry;
	var morePosts = true;
	var currentlyLoading = false;

	function documentReadyFunction() {
		onPageLoad();
		onPageLoadOrResize(); 
	}

	function documentLoadFunction() {
		documentLoad();
		documentLoadOrResize();
	}

	function windowResizeFunction() {
		onPageLoadOrResize();
		documentLoadOrResize();
	}

	function onPageLoad() {
		msnry = $('#post-loop').masonry({
			itemSelector: '.post',
			stamp: '.stamp',
		});

		/**
		 * Hide everything that's only needed if JavaScript is disabled
		 */
		$( '.hide-without-javascript' ).removeClass( 'hide-without-javascript' );
		$( 'html' ).removeClass('no-js').addClass('js');

		$('#logo').load(function() {
			$( '#logo' ).fadeIn('slow');
			supercouthPositionHeader();
		});

		$('#background-img img').load(function() {
			$( '#background-img img' ).fadeIn('slow');
		});	
	}
	
	function onPageLoadOrResize () {
		initMasonry();
		
		supercouthPositionHeader();
	}

	function documentLoad() {
		initMasonry();
		supercouthMailchimpPopUp();
	}

	function documentLoadOrResize() {

	}

	function windowScrollFunction() {
		var scrollTop = $(window).scrollTop();
		var windowHeight = $(window).height();

		var scrollBottom = scrollTop + windowHeight;

		var documentHeight = $('html').height();

		var bottomGap = documentHeight - scrollBottom;

		if( bottomGap < 1000 ) {
			$('.loading-img').css('display', 'block');
			loadPosts();
		}
	}
	
	/* -----------------------------
	SUPPORT FUNCTIONS
	----------------------------- */
		function supercouthMailchimpPopUp() {
			$('.email-newsletter-popup').click(function(event) {
				event.preventDefault();
				document.cookie = "MCEvilPopupClosed=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
				require(["mojo/signup-forms/Loader"], function(L) { 
					L.start({
						"baseUrl":"mc.us4.list-manage.com",
						"uuid":"386543f0f8d9b49a9ad6440a1",
						"lid":"7bca717a1b"
					})
				})
			});
		}
		/**
		 * Position the header images
		 */
		function supercouthPositionHeader() {
			var divHeight = $( '#logo-wrap' ).height();
			var imageHeight = $( '#background-img' ).height();

			var marginTop = ( imageHeight - divHeight ) / 2;
			marginTop = '-' + marginTop + 'px';
			
			$( '#background-img' ).css( 'margin-top', marginTop );

			var logoWidth = $( '#logo' ).width();
			var divWidth = $( '#logo-wrap' ).width();
			
			var logoLeft = ( divWidth - logoWidth ) / 2;
			logoLeft = logoLeft + 'px';
			$( '#logo' ).css( 'left', logoLeft );
			
			
		}

		function initMasonry() {
			msnry.masonry();
		}

		function loadPosts() {
			if(morePosts && !currentlyLoading) {
				currentlyLoading = true;
				var pageID = parseInt($('main').attr('data-page-id'));
				pageID = pageID + 1;

				var url = window.location.href + '?action=get_page&get=' + pageID;

				$('main').attr('data-page-id', pageID);

				$.ajax({
					url: url,
				}).done(function( data ) {

					if( 'no-posts' == data ) {
						morePosts = false;
						$('.loading-img').remove();
					} else {
						data = $(data);
						msnry.append(data).masonry('appended', data).masonry();
						currentlyLoading = false;
					}
				});
			}
		}

}) ( jQuery );