var url = "http://yoannkozlowski.noip.me";

$('#inscription').on('submit', function (e) {
    e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire

    var $this = $(this); // L'objet jQuery du formulaire
    var json = getFormData($this);

    // Envoi de la requête HTTP en mode asynchrone
    $.ajax({
        url: url + $this.attr('action'),
        type: $this.attr('method'),
        data: JSON.stringify(json),
        dataType: 'json',
        statusCode: {
            201: function () {
                window.location = '/';
            },
            400: function () {
                $('#msgAlertInscription').html('<strong>Inscription impossible</strong>').removeAttr('hidden');
            },
            500: function () {
                $('#msgAlertInscription').html('<strong>Erreur serveur</strong><br>Nous avons rencontré un problème, veuillez nous excuser et réessayer').removeAttr('hidden');
            }
        }
    });
});

$('#connexion').on('submit', function (e) {
    e.preventDefault();

    var $this = $(this);
    var json = getFormData($this);

    // Envoi de la requête HTTP en mode asynchrone
    $.ajax({
        url: url + $this.attr('action'),
        type: $this.attr('method'),
        data: JSON.stringify(json),
        dataType: 'json',
        statusCode: {
            200: function () {
                window.location = '/';
            },
            400: function () {
                $('#msgAlertConnection').html('<strong>Connexion impossible</strong><br>Vérifiez votre Email / Mot de passe').removeAttr('hidden');
            },
            500: function () {
                $('#msgAlertConnection').html('<strong>Erreur serveur</strong><br>Nous avons rencontré un problème, veuillez nous excuser et réessayer').removeAttr('hidden');
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