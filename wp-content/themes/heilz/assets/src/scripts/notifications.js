'use strict'

window.$ = window.jQuery

class Notifications {

	constructor() {

		$(document).ready(() => this.ready())

	}

	ready() {

		this.xhr = null

		this.$body = $('body')
		this.$window = $(window)

		this.bind()

	}

	bind() {

		$(`.ulz-npanel [data-action='panel-close']`).on('click', () => {
			this.close()
		})

		$(document).on('utillz:megamenu/expand', () => {
			this.close()
		})

		$(`[data-action='mark-read']`).on('click', (e) => {
			this.read(e)
		})

		$(document).on('click', `[data-action='notifications']`, () => {
			this.open()
		})

		$(document).on('click', `[data-action='notifications-toggle']`, () => {
			if( ! $('#notifications-panel').hasClass('ulz--visible') ) {
				this.open()
			}else{
				this.close()
			}
		})

	}

	read(e) {

		let $e = $(e.currentTarget)
		let $panel = $('#notifications-panel')

		if( $panel.hasClass('ulz-ajaxing') ) {
			return;
		}

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: window.utillz_core_vars.admin_ajax,
			data: {
				action: 'utillz-notifications',
				target: 'mark-read',
			},
			beforeSend: () => {

				$e.addClass('ulz-ajaxing')

				let $icon = $('.ulz-site-notifications > .ulz-site-icon').find('.ulz--icon')
				if( $('span', $icon ).length ) {
					$icon.html('0')
				}

				$('.ulz-npanel .ulz--status').remove()

			},
			complete: () => {

				$e.removeClass('ulz-ajaxing')

			},
			success: ( response ) => {}
		})

	}

	add_event_outside() {

		$(document).on('mousedown.utillz:outside/notifications', e => {
			if( ! $( e.target ).closest('.ulz-npanel, .ulz-site-notifications').length ) {
				this.close()
			}
		})

	}

	remove_event_outside() {

		$(document).off('mousedown.utillz:outside/notifications')

	}

	close() {

		if( this.xhr !== null ) {
            this.xhr.abort()
        }

		$('#notifications-panel').attr('data-page', 1)
			.removeClass('ulz--visible')
			.find(`[data-action='append']`).empty()

		this.$body.css('overflow', '')

		this.remove_event_outside()

	}

	open() {

		let $panel = $('#notifications-panel')

		if( $panel.hasClass('ulz-ajaxing') ) {
			return;
		}

		this.$body.css('overflow', 'hidden')

		if( this.xhr !== null ) {
            this.xhr.abort()
        }

		this.add_event_outside()

		let page = parseInt( $panel.attr('data-page') )

		this.xhr = $.ajax({
			type: 'post',
			dataType: 'json',
			url: window.utillz_core_vars.admin_ajax,
			data: {
				action: 'utillz-notifications',
				target: 'load',
				page: page,
			},
			beforeSend: () => {

				let $list = $('.ulz--list', $panel)

				$panel.addClass('ulz-ajaxing ulz--visible')
				$list.scrollTop( $list.prop('scrollHeight') )

				$panel.attr( 'data-page', page + 1 )

			},
			complete: () => {

				$panel.removeClass('ulz-ajaxing')

			},
			success: ( response ) => {

				$(`[data-action='append']`, $panel).append( response.html )

				if( ! response.more ) {
					$(`.ulz-button[data-action='notifications']`)
						.addClass('ulz--mutted')
						.removeAttr('data-action')
				}

			}
		})
	}

}

export default new Notifications()
