'use strict'

window.$ = window.jQuery

class preview extends Utillz_Core.modal.base {

	visibility() {

		// it will open in a new tab
		// so, prevent visibility
		if( window.utillz_theme_vars.is_mobile ) {
			return;
		}

		this.$.addClass('ulz-visible')
        this.$body.addClass(`ulz-modal-open ulz-modal-open--${this.data.id}`)

    }

    init() {

		// open in a new tab
		if( window.utillz_theme_vars.is_mobile ) {
			// window.open( $(this.e.currentTarget).attr('href') , '_blank').focus()
			window.location.href = $(this.e.currentTarget).attr('href')
			window.Utillz_Core.modal.flush()
			return;
		}

		this.$body = $('body')
		this.$append = $('.ulz-modal-append', this.$)
		this.$gallery = $('.ulz-preview-gallery', this.$)

		this.$item = $(this.e.currentTarget).closest('.ulz-listing-item')
		this.$container = this.$item.closest('.ulz-explore-listings')
		this.index = parseInt( this.$item.attr('data-index') )

		this.xhr = null

		$.ajax({
            type: 'post',
            dataType: 'json',
            url: window.utillz_core_vars.admin_ajax,
            data: {
                action: 'utillz-listing-preview',
				target: 'open',
				id: this.params
            },
			beforeSend: () => {

				this.ajaxing()

			},
			complete: () => {

				this.ready = true
				this.$body.addClass('ulz-listing-preview-ready')

			},
			success: response => {

				window.utillz_theme_vars.action_download_data = response.download_data

				this.$.find('.ulz-listing-preview-skeleton').addClass('ulz-none')
				this.$append.html( response.html )
				this.$.removeClass('ulz-ajaxing')

				// build the gallery
				this.build_gallery()

				// close
				$(`.ulz-modal-listing-preview`).on('click.listing-preview-close', e => {
					if( $(e.target).hasClass('ulz-modal-listing-preview') ) {
						$(document).trigger('utillz:modal/close')
					}
				})
				$(`[data-action='preview-close']`).on('click.listing-preview-close', e => {
					$(document).trigger('utillz:modal/close')
				})

				// navigation
				$('.ulz-preview-nav').on('click.utillz:preview/nav', e => {
					this.navigation(e)
				})

			}
        })

	}

    close() {

		if( this.xhr !== null ) {
            this.xhr.abort()
        }

		this.ready = false
		this.$body.removeClass('ulz-listing-preview-ready')

		$(`.ulz-modal-listing-preview, [data-action='preview-close']`).off('click.listing-preview-close')

		this.$append.html('')
		this.$.find('.ulz-listing-preview-skeleton').removeClass('ulz-none')

		$('.ulz-preview-nav').off('click.utillz:preview/nav')

	}

    ajaxing() {

		if( this.$.hasClass('ulz-ajaxing') ) {
            return
        }
		this.$.addClass('ulz-ajaxing')
        this.$append.html('')

    }

	navigation(e) {

		let $e = $(e.currentTarget)
		let direction = $e.attr('data-action')
		let max_index = this.gallery_length - 1

		let index = this.index
		index = index + ( ( direction == 'preview-next' ) ? +1 : -1 )

		// go to last index
		if( index < 0 ) {
			index = max_index
		}

		// go to first index
		if( index > max_index ) {
			index = 0
		}

		this.index = index

		this.get_item()

	}

	build_gallery() {

		this.gallery_length = this.$container.find('.ulz-listing-item').length

		this.$gallery.empty()
		for( let i = 0; i < this.gallery_length; i++ ) {
			let $item = $(`.ulz-listing-item[data-index='${i}']`, this.$container)
			let index = $item.attr('data-index')
			let params = $item.attr('data-preview-params')
			this.$gallery.append(`<li data-index='${index}' data-preview-params='${params}'></li>`)
		}

	}

	reset_to_image() {

		$('.ulz-cover video', this.$).remove()

	}

	get_item( index ) {

		if( this.xhr !== null ) {
            this.xhr.abort()
        }

		this.reset_to_image()

		let $get = this.$gallery.find(`li[data-index='${this.index}']`)
		let params = JSON.parse( $get.attr('data-preview-params') )

		this.params = params.id

		$(`[data-replace='author']`, this.$).html( $(`.ulz-listing[data-id="${params.id}"]:first`).find('.ulz-cover-author').html() )
		$(`[data-replace='image']`, this.$).attr( 'src', params.image )
		$(`[data-replace='title']`, this.$).html( params.title )
		$(`[data-replace='favorite-id']`, this.$).attr( 'data-id', params.id )
		$(`[data-replace='url']`, this.$).attr( 'href', params.url )
		$(`[data-replace='favorite-id']`, this.$)[ params.favorite ? 'addClass' : 'removeClass' ]('ulz--active')

		if( params.video_src ) {
			$('.ulz--asset', this.$).append(`<video class="ulz--video" loop="" muted="" autoplay data-observed="true" poster="">
                <source src="${params.video_src}" type="video/mp4">
            </video>`)
		}

		this.$.scrollTop(0)

	}
}

Utillz_Core.modal.add_module( 'listing_preview', preview )
