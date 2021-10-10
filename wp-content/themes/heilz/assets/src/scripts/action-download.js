'use strict'

window.$ = window.jQuery

class Action_Download {

	constructor() {

		$(document).ready(() => this.ready())

	}

	ready() {

		this.$body = $('body')
		this.$window = $(window)

		this.bind()

	}

	bind() {

		$(document).on('click', `.ulz-dpanel [data-action='panel-close']`, () => {
			this.close()
		})

		$(document).on('utillz:megamenu/expand', () => {
			this.close()
		})

		$(document).on('click', `[data-action='download-toggle']`, () => {

			if( ! $('.ulz-dpanel').hasClass('ulz--visible') ) {
				this.open()
			}else{
				this.close()
			}

		})

		$(document).on('click', `[data-action='download-process']`, e => {

			let $e = $(e.currentTarget)

			$e.addClass('ulz-ajaxing')
			setTimeout(() => {

				$e.removeClass('ulz-ajaxing')

			}, 2000 )

			$(`.ulz-mod-action-download [data-action='action-download']`).trigger('click')

		})

	}

	add_event_outside() {

		$(document).on('mousedown.utillz:outside/download', e => {
			if( ! $( e.target ).closest('.ulz-dpanel, .ulz-cover-top').length ) {
				this.close()
			}
		})

	}

	remove_event_outside() {

		$(document).off('mousedown.utillz:outside/download')

	}

	close() {

		$('.ulz-dpanel').removeClass('ulz--visible')

		this.$body.css('overflow', '')

		this.remove_event_outside()

	}

	open() {

		$('.ulz-dpanel').addClass('ulz--visible ulz-ajaxing')

		this.$body.css('overflow', 'hidden')

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: window.utillz_core_vars.admin_ajax,
			data: {
				action: 'utillz-listing-preview',
				target: 'plans',
				id: typeof window.Utillz_Core.modal.instance !== 'undefined' ? window.Utillz_Core.modal.instance.params : window.utillz_core_vars.post_id
			},
			beforeSend: () => {

				$(`.ulz-dpanel [data-action='append']`).html('')

			},
			complete: () => {

				$('.ulz-dpanel').removeClass('ulz-ajaxing')

			},
			success: response => {

				$(`.ulz-dpanel [data-action='append']`).html( response.html )

			}
		})

		this.add_event_outside()

	}

}

export default new Action_Download()
