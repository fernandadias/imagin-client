'use strict'

import Mobile from './mobile'
import Notifications from './notifications'
import Action_Download from './action-download'
import inView from 'in-view'
import hoverintent from 'hoverintent'

window.$ = window.jQuery
window.Utillz_Theme = window.Utillz_Theme || {}

class Utillz_Theme {

	constructor() {

		if( window.Utillz_Core ) {
			require('./gallery.js')
			require('./listing-preview.js')
		}

		$(document).ready(() => this.ready())

	}

	ready() {

		this.$body = $('body')
		this.$w = $(window)
		this.$nav = $('.ulz-mobile-nav')

		this.init()
		this.share()
		this.carousel_search()
		this.header()
		this.account_welcome()
		this.author_listing_types()
		this.woocommerce()
		this.widgets()
		this.listing_sidebar()
		this.loading_icons()

	}

	init() {

		this.bind()

	}

	share() {

		$(document).on('click', `[data-action='share']`, e => {
			navigator.share({
				title: document.title,
				url: $(`[data-replace="url"]`).attr('href'),
			})
			.catch(error => console.log('Error sharing', error))
		})

	}

	// gallery() {}

	header() {

		this.header_sticky()

		this.$w.on('scroll', () => {
			this.header_sticky()
		})

		$('.ulz-megamenu').each(( index, element ) => {
			hoverintent( element, () => {

				$(document).trigger('utillz:megamenu/expand')

				let $e = $(element),
					$cols = $e.find('> .ulz-megamenu-container > .ulz-row > .sub-menu > li')

				$e.addClass('ulz--expand')
				this.$body.addClass('ulz--megamenu-open')

				TweenMax.killTweensOf( $cols )
				TweenMax.staggerFromTo(
					$cols,
					.35,
					{ y: -20, opacity: 0 },
					{ y: 0, opacity: 1, delay: .15 },
					.1
				)

			}, () => {

				$(document).trigger('utillz:megamenu/close')

				let $e = $(element),
					$cols = $e.find('> .ulz-megamenu-container > .ulz-row > .sub-menu > li')

				$e.removeClass('ulz--expand')
				this.$body.removeClass('ulz--megamenu-open')

				TweenMax.set(
					$cols,
					{ y: -20, opacity: 0 },
				)

			}).options({
				timeout: 300,
				interval: 50
			})
		})

		// user drop-down
		$(`[data-action='user-actions']`).on('click', () => {
			let $panel = $('.ulz-upanel')
			$panel.toggleClass('ulz--visible')
			if( $panel.hasClass('ulz--visible') ) {
				this.add_upanel_event_outside()
			}else{
				$(document).off('mousedown.utillz:outside/user-actions')
			}
		})

		$(document).on('utillz:megamenu/expand', () => {
			$('.ulz-upanel').removeClass('ulz--visible')
		})

	}

	add_upanel_event_outside() {

		$(document).on('mousedown.utillz:outside/user-actions', e => {

			if( ! $( e.target ).closest('.ulz-upanel, .ulz-site-user').length ) {
				 $('.ulz-upanel').removeClass('ulz--visible')
			}

		})

	}

	header_sticky() {

		if( this.$w.scrollTop() > 0 ) {
			if( ! this.$body.hasClass('ulz--is-sticky') ) {
				this.$body.addClass('ulz--is-sticky')
			}
		}else{
			if( this.$body.hasClass('ulz--is-sticky') ) {
				this.$body.removeClass('ulz--is-sticky')
			}
		}

	}

	carousel_search() {

		let $carousel = $('.ulz-search')
		let $nav = $('.ulz-carousel-nav')
		let $li = $( 'li', $nav )

		if( $nav.length ) {
			$li.on('click', e => {

				let $e = $( e.currentTarget )
				let index = $e.attr('data-for')

				$li.removeClass('ulz-active')
				$e.addClass('ulz-active')

				$('.ulz--content', $carousel).removeClass('ulz-active')
				$(`.ulz--content[data-id='${index}']`, $carousel).addClass('ulz-active')

			})
		}

	}

	bind() {

		$(document).on('click', 'a[href="#"]', e => { e.preventDefault() })
		$(document).on('click', `[data-action='browser-back']`, e => {
			// if browser history, use it
			if( window.history.length && document.referrer !== '' ) {
				e.preventDefault()
				window.history.back()
			}
		})

	}

	account_welcome() {

		let $e = $('.ulz-account-welcome')

		if( $e.length ) {
			TweenMax.to( $e.parent(), .65, { height: $e.outerHeight(), marginBottom: '.75rem', delay: .25, ease: 'power4.inOut', onComplete: () => {
				$e.parent().css('height', 'auto')
			}})
		}

		$(`.ulz-account-welcome [data-action='close']`).on('click', () => {
			TweenMax.to( $e.parent(), 1, { height: 0, marginBottom: 0, ease: 'power4.inOut' } )
		})

	}

	author_listing_types() {

		$(`[data-action='author-listing-types']`).on('change', e => {

			let listing_type_slug = e.currentTarget.value

			const urlParams = new URLSearchParams( window.location.search )

			if( $(`[data-action='author-listing-types'] option`).index( $( e.currentTarget ).find('option:selected') ) == 0 ) {
				urlParams.delete('type')
			}else{
				urlParams.set('type', listing_type_slug)
			}

			urlParams.delete('onpage')
			window.location.search = urlParams

		})

	}

	woocommerce() {

		$(document).on('click', '.ulz-quantity .ulz--actions span', e => {

			let $e = $(e.currentTarget);
			let $input = $e.closest('.ulz-quantity').find('input')

            if( $e.hasClass('ulz--plus') ) {
                $input.get(0).stepUp(1)
            }else{
				$input.get(0).stepDown(1)
            }

			$input.trigger('input')

		})

	}

	widgets() {

		let $archive = $(`.ulz-widget select, .variations select`)
		if( $archive.length ) {
			$archive.wrap('<div class="ulz-archive-dropdown"></div>')
		}

	}

	listing_sidebar() {

		// aside selector
		let $aside = $('.ulz-listing-sidebar > .ulz--inner.ulz--sticky')

		if( ! $aside.length ) {
			return;
		}

		const aside = $aside.get(0),
			start_scroll = 70

		let end_scroll = window.innerHeight - aside.offsetHeight - 500,
			curr_pos = window.scrollY,
			screen_height = window.innerHeight,
			aside_height = aside.offsetHeight

		aside.style.top = start_scroll + 'px'

		// check height screen and aside on resize
		window.addEventListener('resize', () => {
		    screen_height = window.innerHeight
		    aside_height = aside.offsetHeight
		})

		document.addEventListener('scroll', () => {

			end_scroll = window.innerHeight - aside.offsetHeight
		    let aside_top = parseInt( aside.style.top.replace('px;', '') )

		    if( aside_height > screen_height ) {

				// scroll up
		        if( window.scrollY < curr_pos ) {
		            if( aside_top < start_scroll ) {
		                aside.style.top = ( aside_top + curr_pos - window.scrollY ) + 'px'
		            }else if( aside_top >= start_scroll && aside_top != start_scroll ) {
		                aside.style.top = start_scroll + 'px'
		            }
		        }
				// scroll down
				else{
		            if( aside_top > end_scroll) {
		                aside.style.top = ( aside_top + curr_pos - window.scrollY ) + 'px'
		            }else if( aside_top < ( end_scroll ) && aside_top != end_scroll ) {
		                aside.style.top = end_scroll + 'px'
		            }
		        }

		    }

		    curr_pos = window.scrollY

		},
		{
		    capture: true,
		    passive: true
		})

	}

	loading_icons() {
		this.$body.removeClass('ulz--loading-icons')
	}

}

window.Utillz_Theme = new Utillz_Theme()
