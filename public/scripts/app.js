let indice = -1;

document.addEventListener('DOMContentLoaded', function() {
    caregarongs();
    document.getElementById("mapinha").style.visibility = "hidden";

});

function caregarongs(){
    let results = "";
    let resultado = document.getElementById("CentroDoacoes")

    
    for (let ong of ongs){
          results +=   `<div class="card-ong">
                            <div class="tituloong">
                                <h1>${ong.nome}</h1>
                            </div>
                            <div class = "logoong">
                                <img src="${ong.img}" alt="Logo da ong ${ong.nome}" style="width: 100%; object-fit: contain;">
                            </div>
                            <div class="infoong">
                                <p class= "modadalidade">
                                    <strong>O que doar/Como ajudar:</strong> ${ong.tem}
                                </p>
                                <p class= "endereco" onclick="mapa(${ong.id})">
                                    <strong>📍Endereço:</strong> ${ong.endereco}
                                </p>
                            </div>
                            <div class="saibamaisong">
                                <a href="${ong.link}" target="_blank" rel="external">
                                Saiba mais</a> 
                            </div>
                        </div>`
    }
    resultado.innerHTML = results;
}

function mapa(id){
    document.getElementById("mapinha").hidden = false;
    let results = "";
    let resultado = document.getElementById("mapinha")
    resultado.innerHTML = ""
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: 'smooth'
    });

    document.getElementById("mapinha").style.visibility = "visible";


    if (ongs[id].frame != " " && ongs[id].frame != null) {
        resultado.innerHTML += `<iframe src=${ongs[id].frame} width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`
    } else{
        resultado.innerHTML += `<p class="avisoong">Essa ONG não possui endereço, ajude eles <a href="${ongs[id].link}" target="_blank" rel="external">Clicando aqui.</a></p>`
    }


}