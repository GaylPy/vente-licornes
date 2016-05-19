$('#inscription').on('submit', function (e) {
    e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire

    var $this = $(this); // L'objet jQuery du formulaire
    var json = getFormData($this);

    // Envoi de la requête HTTP en mode asynchrone
    $.ajax({
        url: $this.attr('action'),
        type: $this.attr('method'),
        data: JSON.stringify(json),
        dataType: 'json',
        success: function (result) {
            if (result.message == "ok") {
                alert('Tout est bon');
            } else {
                alert('Erreur : ' + result.message);
            }
        }
    });
});

$('#connexion').on('submit', function (e) {
    e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire

    var $this = $(this); // L'objet jQuery du formulaire
    var json = getFormData($this);

    // Envoi de la requête HTTP en mode asynchrone
    $.ajax({
        url: $this.attr('action'),
        type: $this.attr('method'),
        data: JSON.stringify(json),
        dataType: 'json',
        success: function (result) {
            if (result.message == "ok") {
                alert('Tout est bon');
            } else {
                $("#messageAlerte").html('<div class="alert alert-danger" role="alert">' +
                    '<strong>Erreur !</strong> Veuillez vérifier votre email ou votre mot de passe</div>');
            }
        }
    });
});

function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}