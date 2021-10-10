'use strict'

window.$ = window.jQuery
window.Utillz = window.Utillz || {}

class gallery extends Utillz_Core.modal.base {

	constructor( data ) {

		super( data )

		this.$append = $('.ulz-modal-image', this.$)

		this.ajaxing()

		let $image = $(`<img src="${this.params}">`)

		$image.imagesLoaded(() => {

			this.$append.html( $image )
			this.$.removeClass('ulz-ajaxing')

		})

    }

    init() {}

    close() {
		this.$append.html('')
	}

    ajaxing() {

		if( this.$.hasClass('ulz-ajaxing') ) {
            return
        }
		this.$.addClass('ulz-ajaxing')
        this.$append.html('')

    }
}

Utillz_Core.modal.add_module( 'gallery', gallery )

class Gallery {

	constructor() {

		$(document).ready(() => this.ready())

	}

	ready() {

		this.init()

	}

	init() {

		this.$modal = $('.ulz-modal-gallery')

		$(document).on('click', '.ulz--gallery-lighbox .ulz--image', e => this.image_click(e) )
		$(document).on('click', `[data-action='expand-gallery']`, e => this.expand_gallery(e) )

		$(document).on('click', '.ulz-gallery', e => this.open(e) )
		$(document).on('click', '.ulz-gallery-nav', e => this.nav(e) )

	}

	image_click(e) {

		e.preventDefault()

		let $e = $(e.currentTarget)
		let $cover = $e.closest('.ulz--gallery-lighbox')
		let index = $('.ulz--image', $cover).index( $e )

		$('.ulz-gallery', $cover).eq( index ).trigger('click')

	}

	expand_gallery(e) {

		$(e.currentTarget).closest('.ulz--gallery-lighbox').find('.ulz--image:first').trigger('click')

	}

	open(e) {

		let $e = $(e.currentTarget)
		this.$stack = $e.closest('.ulz-gallery-stack')
		this.index = this.$stack.children().index( $e )
		this.is_stack = this.$stack.children().length > 1

		this.$modal[ this.is_stack ? 'addClass' : 'removeClass' ]('ulz-is-stack')

		this.$modal.find('.ulz--current').html( this.index + 1 )
		this.$modal.find('.ulz--total').html( this.$stack.children().length )

		window.Utillz_Core.modal.open( 'gallery', $e.data('image') )

	}

	nav(e) {

		if( this.$modal.hasClass('ulz-ajaxing') ) {
			return;
		}

		let $e = $(e.currentTarget)
		let is_next = $e.attr('data-action') == 'next'

		this.$modal.addClass('ulz-ajaxing')

		let next_index = this.index + ( is_next ? 1 : -1 )

		if( next_index < 0 ) {
			next_index = this.$stack.children().length - 1
		}

		if( this.$stack.children().length - 1 < next_index ) {
			next_index = 0
		}

		let next_image_src = this.$stack.children().eq( next_index ).attr('data-image')

		let $image = $(`<img src="${next_image_src}">`)

		$image.imagesLoaded(() => {

			this.index = next_index

			this.$modal.find('.ulz--current').html( next_index + 1 )

			$('.ulz-modal-image', this.$modal).html( $image )
			this.$modal.removeClass('ulz-ajaxing')

		})

	}

}

window.Utillz.gallery = new Gallery()
