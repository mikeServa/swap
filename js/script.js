$(document).ready(function() {

    //Stylisation du formulaire pendant la saisie
    function input_valid($id, $longueur) {

        $('#' + $id).on('keyup', function(e) {

            if (($('#' + $id).val()).length < $longueur) {
                $('#' + $id).css('color', 'red');
            } else {
                $('#' + $id).css('color', 'black');
            }
        });
    }
    input_valid('titre', 3);
    input_valid('description_courte', 5);
    input_valid('description_longue', 30);
    input_valid('mdp', 8);
    input_valid('pseudo', 3);
    input_valid('nom', 5);
    input_valid('prenom', 5);
    input_valid('code_postal', 5);


    //gestion de la selection des catégories

    function input_focus($select) {
        $($select).css('backgroundColor', 'red').css('color', 'white');

        $($select).on('change', function() {

            $($select).css('backgroundColor', 'green');
            $($select).css('color', 'white');


        });
    }
    input_focus($('#categorie'));
    input_focus($('#ville'));







    //traitement du formulaire code postale et ville
    const apiUrl = "https://geo.api.gouv.fr/communes?codePostal=";
    const format = '&format=json';

    let codepostal = $('#code_postal');
    let ville = $('#ville');
    let erreur_code_postale = $('#erreur_code_postal');

    // blur est envoyé à un élément lorsqu'il perd le focus
    $(codepostal).on('blur', function() {
        let code = $(this).val(); //on reccupere la valeur du formulaire
        let url = apiUrl + code + format;
        console.log(code);
        console.log(url);

        fetch(url, { method: 'get' }).then(response => response.json()).then(results => {
            console.log(results);
            $(ville).find('option').remove(); //Supprime les options pour pas qu'elles s'ajoutents à la liste precedente 
            if (results.length) {
                $(erreur_code_postale).hide();

                $.each(results, function(key, value) {
                    //console.log(value.nom); //.nom pour reccuperer le nom de la communce voir la documentation de l'api https://api.gouv.fr/documentation/api-geo
                    //console.log(value);
                    $(ville).append('<option name="' + value.nom + '" value="' + value.nom + '" class="form-select ">' + value.nom + '-' + value.code + '</option>') //permet de remplir un champ html
                    $(ville).css('backgroundColor', 'green');
                    $(ville).css('color', 'white');


                });
            } else {
                if ($(codepostal).val()) {
                    console.log('erreur de saisie');
                    $(erreur_code_postale).text('Aucune commune avec ce code postal').show();
                } else {
                    $(erreur_code_postale).hide();
                }

            }
        }).catch(err => {
            console.log(err); //permet de voir l'erreur
        })
    });




    //traitement formulaire région





    let region = $('#region');


    // blur est envoyé à un élément lorsqu'il perd le focus
    $(codepostal).on('blur', function() {
        let code = $(this).val(); //on reccupere la valeur du formulaire
        let url = apiUrl + code + format;
        console.log(code);
        console.log(url);

        fetch(url, { method: 'get' }).then(response => response.json()).then(results => {
            console.log(results);
            $(region).find('option').remove(); //Supprime les options pour pas qu'elles s'ajoutents à la liste precedente 
            if (results.length) {
                $(erreur_code_postale).hide();

                $.each(results, function(key, value) {
                    //console.log(value.nom); //.nom pour reccuperer le nom de la communce voir la documentation de l'api https://api.gouv.fr/documentation/api-geo
                    //console.log(value);
                    $(region).append('<option name="' + value.nom + '" value="' + value.nom + '" class="form-select ">' + value.nom + '-' + value.code + '</option>') //permet de remplir un champ html

                });
            } else {
                if ($(codepostal).val()) {
                    console.log('erreur de saisie');
                    $(erreur_code_postale).text('Aucune commune avec ce code postal').show();
                } else {
                    $(erreur_code_postale).hide();
                }

            }
        }).catch(err => {
            console.log(err); //permet de voir l'erreur
        })
    });




    //traitement du depot de photo dans annonce

    if (document.getElementById('preview')) {

        document.getElementById('photo1').addEventListener('change', function(event) {

            let fichier = event.target.files[0];
            console.log(fichier);
            let ext = ['image/jpeg', 'image/png', 'image/gif'];
            if (ext.includes(fichier.type)) {
                let reader = new FileReader();
                reader.readAsDataURL(fichier);
                reader.onload = (e) => {
                    document.querySelector('#preview img').setAttribute('src', e.target.result);

                    // Pour les articles
                    if (document.getElementById('nom_original')) {
                        // mémoriser les informations du fichier image
                        document.getElementById('nom_original').setAttribute('value', fichier.name);
                        document.getElementById('data_img').setAttribute('value', e.target.result);
                    }

                }
            }

        });

    }

    //preview image 


    /*    $i = 1;
       while ($i <= 5) {
           $('#input' + $i).on('change', function() {
               console.log('ok');
               $(`#preview` + $i).show();

               $(`#photos` + $i).hide();

           });
           $i++;
       } */

    $('#input1').on('change', function() {
        console.log('ok');
        $(`#preview1`).show();

        $(`#photos1`).hide();

    });
    $('#input2').on('change', function() {
        console.log('ok');
        $(`#preview2`).show();

        $(`#photos2`).hide();

    });
    $('#input3').on('change', function() {
        console.log('ok');
        $(`#preview3`).show();

        $(`#photos3`).hide();

    });
    $('#input4').on('change', function() {
        console.log('ok');
        $(`#preview4`).show();

        $(`#photos4`).hide();

    });
    $('#input5').on('change', function() {
        console.log('ok');
        $(`#preview5`).show();

        $(`#photos5`).hide();

    });







});