let date = document.querySelector('.date');
let k = 0;
let titreSuperviser = document.querySelector(".superviseur__titre");

$(document).ready(function () {
    $("#addclient").click(function () {
        let nouveauClient = document.querySelector(".nouveau-client");
        nouveauClient.classList.toggle("none");
    })
    //Lance la requête ajax lors du click
    $("#supermode").click(function () {
        let superviseur = document.querySelector(".superviseur");
        let msgConfirm = document.querySelector(".confirm");
        let msgCreateConfirm = document.querySelector(".confirmation");
        superviseur.classList.toggle("none");
        if (msgConfirm) {
            msgConfirm.remove();
        }
        if(msgCreateConfirm) {
            msgCreateConfirm.remove();
        }

        //Recupère les infos clients de la bdd et les affiche 
        $.ajax({
            url: "/www/exos/t2i/app/views/home/processing/superviser.php",
            method: "GET",
            contentType: "application/json",
            dataType: "json",
            success: function (response) {
                if (response.length == 0) {
                    let vide = document.createElement("li");
                    let message = "Aucun client trouvé.";
                    vide.textContent = message;
                    $("#alarme-libre").append(vide);

                } else {
                    let htmlLibre = "";
                    let htmlPrise = "";
                    for (let i = 0; i < response.length; i++) {

                        if (response[i].alarme == 'libre') {
                            let templateLibre = `
                            <li class="alarmes-libres__item" id="client-${response[i].id}" data-status="libre">${response[i].prenom}</li>
                            `;
                            htmlLibre += templateLibre;
                        } else if (response[i].alarme == 'prise') {
                            let templatePrise = `
                        <li class="alarmes-prises__item" id="client-${response[i].id}" data-status="prise">${response[i].prenom}</li>
                        `;
                            htmlPrise += templatePrise;
                        }
                    }
                    $("#alarme-libre").html(htmlLibre);
                    $(".alarmes-prises").html(htmlPrise);

                    let clientsLibre = document.querySelectorAll('[data-status="libre"]');
                    let clientsPrise = document.querySelectorAll('[data-status="prise"]');

                    for (let x = 0; x < clientsLibre.length; x++) {
                        libresToPrises(clientsLibre[x]);
                        getClientInfo(clientsLibre[x]);
                    }

                    for (let x = 0; x < clientsPrise.length; x++) {
                        prisesToLibres(clientsPrise[x]);
                        getClientInfo(clientsPrise[x]);
                    }
                }
            }
        });

        setInterval(function () {
            k += 1;
            date.innerHTML = updateDate();
        }, 1000)
    });
});

/**
 * Deplace le client de la liste alarmes-prises vers alarmes-libres 
 * Change le statut dans la bdd via fonction changeStatus() 
 * @param {HTMLElement} html 
 */
function libresToPrises(html) {
    html.addEventListener('dblclick', e => {
        let id = html.id;
        id = id.replace("client-", "");
        changeStatus(id, 'prise');
        let newNode = html.cloneNode(true);
        $(".alarmes-prises").append(newNode);
        html.remove();
        prisesToLibres(newNode);
        getClientInfo(newNode);
    })
}

/**
 * Deplace le client de la liste alarmes-prises vers alarmes-libres 
 * Change le statut dans la bdd via fonction changeStatus() 
 * @param {HTMLElement} html 
 */
function prisesToLibres(html) {
    html.addEventListener('dblclick', e => {
        let id = html.id;
        id = id.replace("client-", "");
        changeStatus(id, 'libre');
        let newNode = html.cloneNode(true);
        $(".alarmes-libres").append(newNode);
        html.remove();
        libresToPrises(newNode);
        getClientInfo(newNode);
    })
}

/**
 * Requête Ajax info clients 
 * Affiche les infos dans html
 * @param {HTMLElement} html 
 */
function getClientInfo(html) {
    html.addEventListener('click', e => {
        let id = html.id.replace("client-", "");
        let url = "/www/exos/t2i/app/views/home/processing/clientinfo.php?id=" + id;
        $.ajax({
            url: url,
            method: "GET",
            contentType: "application/json",
            dataType: "json",
            success: function (response) {
                $("#information").remove();

                for (let i = 0; i < response.length; i++) {
                    let monthBirth = response[i].month_birth;
                    let dayBirth = response[i].day_birth;
                    let year = new Date().getFullYear();
                    let now = dayjs();
                    const date1 = dayjs("'" + year + "-" + monthBirth + "-" + dayBirth + "'");
                    let notif = date1.diff(now, 'week', true);
                    let info = document.createElement("div");
                    let notifText;
                    if (date1.date() == now.date() && date1.month() == now.month()) {
                        notifText = `<span style="color: red; background-color: #787878;">` + response[i].naissance + `</span>`;
                    } else if (notif <= 1.0 && notif > 0) {
                        notifText = `<span style="color: orange; background-color: #787878;">` + response[i].naissance + `</span>`;
                    } else if (notif >= -1.0 && notif < 0) {
                        notifText = `<span style="color: yellow; background-color: #787878;">` + response[i].naissance + `</span>`;
                    } else {
                        notifText = `<span style="color: white; background-color: #787878;">` + response[i].naissance + `</span>`;
                    }
                    let code = `
                        <div class="detail-grid">
                            <span class="detail-title">Prenom :</span>
                            <span>`+ response[i].prenom + `</span>
                            <span class="detail-title">Nom :</span>
                            <span>`+ response[i].nom + `</span>
                        </div>
                        <div class="detail-grid">
                            <span class="detail-title">Date de naissance :</span>`
                        + notifText +
                        `</div>
                        <div class="detail-grid">
                            <span class="detail-title">Age :</span>
                            <span>`+ response[i].age + `</span>
                        </div>
                        <div class="detail-grid">
                            <span class="detail-title">Mail :</span>
                            <span>`+ response[i].mail + `</span>
                        </div>
                        <div class="detail-grid">
                            <span class="detail-title">Adresse :</span>
                            <span>`+ response[i].adresse + `</span>
                        </div>
                        <div class="detail-grid">
                            <span class="detail-title">Tel :</span>
                            <span>`+ response[i].tel + `</span>
                        </div>`;
                    info.id = "information";
                    info.innerHTML = code;
                    $(".info").append(info);
                }
            }
        });
    })
}

/**
 * Requête ajax changement statut
 * Affiche une confirmation ou message d'erreur
 * @param {int} id 
 * @param {string} status ("libre" ou "prise")
 */
function changeStatus(id, status) {
    let url = "/www/exos/t2i/app/views/home/processing/alarmes.php?id=" + id + "&status=" + status;
    $.ajax({
        url: url,
        method: "GET",
        contentType: "application/json",
        dataType: "json"
    })

        .done(function (data) {
            let confirm = document.querySelector(".confirm");
            let block = document.createElement("div");
            if (!confirm) {
                block.classList.add('confirm');
                let message = `
            <span class="confirmation">Le changement de statut a bien été enregistré.</span>
            `;
                block.innerHTML = message;
                titreSuperviser.after(block);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            let error = document.querySelector(".confirm");
            let block = document.createElement("div");
            if (!error) {
                block.classList.add('confirm');
                let message = `
            <span class="error">Le changement de statut n'a pas été enregistré.</span>
            `;
                block.innerHTML = message;
                titreSuperviser.after(block);
            }
        })

}

/**
 * Affiche la date et l'heure
 * @returns string 
 */
function updateDate() {
    let date = new Date();
    today = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();

    hour = new Date().getHours();
    minute = new Date().getMinutes();
    second = new Date().getSeconds();

    result = today + ' ' + hour + ':' + minute + ':' + second;
    return result;
}

