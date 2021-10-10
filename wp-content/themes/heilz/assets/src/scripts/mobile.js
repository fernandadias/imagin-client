'use strict'

window.$ = window.jQuery

class Mobile {

	constructor() {

		$(document).ready(() => this.ready())

	}

	ready() {

		this.$body = $('body')
		this.$window = $(window)
		this.$nav = $('.ulz-mobile-nav')

		this.bind()

	}

	bind() {

		$(`[data-action='toggle-mobile-nav']`).on('click', () => this.toggle_mobile_nav() )
		$('.ulz-nav-mobile .menu-item-has-children > a').on('click', e => this.toggle_sub_menu(e) )
		$(`[data-action='account-mobile-nav']`).on('change', e => this.account_mobile_nav(e) )
		$(`[data-action='mobile-search']`).on('click', () => this.mobile_search() )

	}

	toggle_mobile_nav() {

		this.$body.toggleClass('ulz-do-mobile-nav')

		if( this.$body.hasClass('ulz-do-mobile-nav') ) {

			this.$body.css('overflow', 'hidden')

			TweenMax.fromTo(
				this.$nav,
				.4,
				{ visibility: 'hidden', x: '100%' },
				{ visibility: 'visible', x: 0, ease: 'power4.inOut' }
			)

		}else{

			this.$body.css('overflow', '')

			TweenMax.to(
				this.$nav,
				.4,
				{ x: '100%', ease: 'power4.inOut' }
			)

		}

	}

	toggle_sub_menu(e) {

		let $e = $( e.currentTarget )
		let $li = $e.parent('li')

		if( ! $li.hasClass('ulz--expand') ) {
			e.preventDefault()
		}

		$li.toggleClass('ulz--expand')
			.find('> .sub-menu').toggleClass('ulz-block')

	}

	account_mobile_nav(e) {
		window.location.href = e.target.value
	}

	mobile_search() {
		this.$body.toggleClass('ulz-mobile-search--visible')
	}

}

export default new Mobile()
