jQuery(':button').click(function () {
    if (this.id == 'president') {
        $('#presDiv').fadeIn();
        $('#ivPresDiv').fadeOut();

    }
    else if (this.id == 'internalPres') {
        $('#ivPresDiv').fadeIn();
        $('#presDiv').fadeOut();
    }
});