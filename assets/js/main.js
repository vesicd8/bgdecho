window.addEventListener("load", function () {
  let location = this.location.href;
  if (location.includes("index.php")) {
    $('#anketa').removeClass('d-flex');
    $('#anketa').hide();

    $('#reply-remove').click(function (e) {
      e.preventDefault();
      $('#anketa').removeClass('d-flex');
      $('#anketa').hide();
    });

    this.setTimeout(function () {
      $.ajax({
        url: "models/korisnik/anketa.php",
        method: "POST",
        data: {
          proveriAnketu: true
        },
        success: function (data) {
          if (!data.odradjeno) {
            let html = `
            <h2>${data.anketaPitanje.pitanje}</h2>
            <ul class="list-group m-5">`;
            for (let odg of data.anketaOdg) {
              html += `<li class="list-group-item pr-5 pl-5">
              <input type="radio" value="${odg.odgovor_id}" name="anketa">${odg.odgovor}
              </li>`;
            }
            html += `</ul>`;
            $('#anketaPitanje').html(html);
            $('#anketa').addClass('d-flex');
            $('#anketa').show();
            $('#btnOdradiAnketu').attr('data-anketaid', data.anketaPitanje.anketa_id);

            $('#btnOdradiAnketu').click(function () {
              let anketaOdg = $('input[name=anketa]:checked').val();
              let anketaid = $(this).data('anketaid');
              if (anketaOdg == undefined) {
                $('#anketaPor').html('<p class="text-danger">Morate izabrati odgovor</p>');
              }
              else {
                $.ajax({
                  url: "models/korisnik/uradiAnketu.php",
                  method: "POST",
                  data: {
                    anketaid: anketaid,
                    anketaOdg: anketaOdg,
                    btnUradiAnketu: true
                  },
                  success: function (data) {
                    $('#anketa').removeClass('d-flex');
                    $('#anketa').hide();
                  },
                  error: function (xhr) {
                    let obj = JSON.parse(xhr.responseText);
                    let html = "";
                    for (greska of obj.greske) {
                      html += `<p class="text-danger">${greska}</p>`;
                    }
                    $("#userMessage").html(html);
                  }
                });
              }
            });
          }
        }
      });
    }, 3000);

  }
  else if (location.includes("register.php")) {
    $("#registrujKorisnika").click(function () {
      let ime = $("#ime-register").val();
      let prezime = $("#prezime-register").val();
      let username = $("#korIme-register").val();
      let lozinka = $("#lozinka-register").val();
      let lozinkaProvera = $("#lozinka-provera").val();
      let email = $("#email-register").val();

      $.ajax({
        url: "models/korisnik/register-new-user.php",
        method: "POST",
        data: {
          ime: ime,
          prezime: prezime,
          username: username,
          lozinka: lozinka,
          proveraLozinke: lozinkaProvera,
          email: email,
          btnRegistruj: true
        },
        success: function (data) {
          $("#userMessage").html(`<p class="text-success">${data.poruka}</p>`);
          $("#aktivacioniLink").html(`<a href="models/korisnik/activate.php?kod=${data.aktivacioniKod}">Aktiviraj nalog</a>`);
        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);
          let html = "";
          for (greska of obj.greske) {
            html += `<p class="text-danger">${greska}</p>`;
          }
          $("#userMessage").html(html);
        }
      });

    });
  } else if (location.includes("nalog.php")) {
    $("#izmeni").click(function () {
      let ime = $("#ime").val();
      let prezime = $("#prezime").val();
      let email = $("#email").val();
      let password = $("#pass").val();
      $.ajax({
        url: "models/korisnik/updateinfo.php",
        method: "POST",
        data: {
          ime: ime,
          prezime: prezime,
          lozinka: password,
          email: email,
          btnIzmeni: true
        },
        success: function (data) {
          window.location.reload();
          $("#poruke").html(`<p class="text-success">${data.poruka}</p>`);
        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);
          let html = "";
          for (let poruka of obj.greske) {
            html += `<p class="text-danger">${poruka}</p>`;
          }
          $("#poruke").html(html);
        }
      });
    });
  } else if (location.includes("promenalozinke.php")) {

    $("#promeni").click(function () {
      let greske = [];
      let trenutna = $("#trenutna").val();
      let nova = $("#nova").val();
      let potvrdi = $("#potvrdi").val();
      let lozinkaRe = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
      if(!lozinkaRe.test(nova) || !lozinkaRe.test(potvrdi)){
        greske.push('Lozinka mora da ima minimum 8 karaktera i mora da sadrži bar jedan broj.');
      }
      if(nova != potvrdi){
        greske.push('Lozinke se ne poklapaju.');
      }
      if(trenutna == '' || nova == '' || potvrdi == ''){
        greske.push('Morate popuniti sva polja.');
      }
      if(greske.length == 0){
        $.ajax({
          url: "models/korisnik/changepassword.php",
          method: "POST",
          data: {
            trenutna: trenutna,
            nova: nova,
            potvrdi: potvrdi,
            btnPromena: true
          },
          success: function (data) {
            window.location.href = "login.php";
          },
          error: function (xhr) {
            let obj = JSON.parse(xhr.responseText);
            let html = "";
            for (let poruka of obj.greske) {
              html += `<p class="text-danger">${poruka}</p>`;
            }
            $("#poruke").html(html);
          }
        });
      }
      else{
        let html = "";
        for (let greska of greske) {
          html += `<p class="text-danger">${greska}</p>`;
        }
        $("#poruke").html(html);
      }

    });
  } else if (location.includes("admin.php")) {

    $('#pretraziKorisnika').click(function () {

      let pretraga = $('#pretrazi').val();

      $.ajax({
        url: "models/admin/pretragakorisnika.php",
        method: "POST",
        data: {
          btnPretraga: true,
          pretraga: pretraga
        },
        success: function (data) {
          $('#greskePretraga').html("");
          let html = '<option value="">Izaberi korisnika</option>';
          for (let i of data.korisnici) {
            html += `<option value="${i.korisnik_id}">${i.korisnik_korisnicko_ime}</option>`;
          }
          $('#korisnici').removeAttr('disabled');
          $('#korisnici').html(html);

          $('#korisnici').change(function () {
            if ($(this).val() != '') {

              $('#uloga').removeAttr('disabled');
              $('#btnBanuj').removeAttr('disabled');
              $('#btnUloga').removeAttr('disabled');

            }
            else {
              $('#uloga').attr('disabled', 'true');
              $('#btnBanuj').attr('disabled', 'true');
              $('#btnUloga').attr('disabled', 'true');
            }
          });
        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);
          $('#greskePretraga').html(`<p class="text-danger">${obj.poruka}</p>`);
          $('#korisnici').attr('disabled', 'true');
        }
      });


    });

    statistika();
    $('#update-excel').click(function(e){
      e.preventDefault();
      $.ajax({
        url: "models/admin/excel.php",
        method: "POST",
        data: {
          request: true
        },
        success: function (data) {
          console.log(data);
        },
        error: function (xhr) {
          console.log(xhr);
          console.log(xhr.responseText);
        }
      });

    });


    $('#btnKreirajAnketu').click(function () {

      let pitanje = $('#novaAnketa').val();

      $.ajax({
        url: "models/admin/kreirajAnketu.php",
        method: "POST",
        data: {
          pitanje: pitanje,
          btnKreirajAnketu: true
        },
        success: function (data) {

          $('#kreirajAnketuPoruke').html(`<p class="text-success">${data.poruka}</p>`);
          reload();

        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);
          $('#kreirajAnketuPoruke').html(`<p class="text-danger">${obj.poruka}</p>`);
        }
      });

    });

    $('#btnDodajOdgovor').click(function () {
      let anketa = $('#ankete').val();
      let noviOdg = $('#dodajOdgovor').val();

      $.ajax({
        url: "models/admin/dodajOdgovor.php",
        method: "POST",
        data: {
          pitanje: anketa,
          odgovor: noviOdg,
          btnDodajOdgovor: true
        },
        success: function (data) {
          $('#dodajOdgPoruke').html(`<p class="text-success">${data.poruka}</p>`);

        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);
          let html = "";
          for (let o of obj.greske) {
            html += `<p class="text-danger">${o}</p>`;
          }
          $('#dodajOdgPoruke').html(html);
        }
      });
    });

    $('#izmeniOdgovoreDdl').change(function () {
      let opcija = $(this).val();
      $.ajax({
        url: "models/admin/izmeniOdgovore.php",
        method: "POST",
        data: {
          anketaId: opcija,
          izmeniOdgovore: true
        },
        success: function (data) {
          let html = '';
          for (let odg of data.odgovori) {
            html += `<option value="${odg.odgovor_id}">${odg.odgovor}</option>`;
          }
          $('#izmeniOdgovorPoruke').html("");
          $('#odgovoriDdl').html(html);

        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);

          $('#odgovoriDdl').html("<option value=''>Nema odgovora</option>");
          $('#izmeniOdgovorPoruke').html(`<p class="text-danger">${obj.poruka}</p>`);
        }
      });
    });

    $('#izmeniPitanjeDdl').change(function () {
      let anketaid = $(this).val();
      $.ajax({
        url: "models/admin/izmeniPitanje.php",
        method: "POST",
        data: {
          anketaId: anketaid,
          izmeniPitanjeDdl: true
        },
        success: function (data) {
          $('#tbIzmeniPitanje').attr('value', data.pitanje.pitanje);
          $('#izmeniPitanjePoruke').html("");
        },
        error: function (xhr) {

        }
      });
    });

    $('#btnIzmeniAnketu').click(function () {

      let anketaId = $('#izmeniPitanjeDdl').val();
      let novoPitanje = $('#tbIzmeniPitanje').val();

      $.ajax({
        url: "models/admin/izmeniPitanje.php",
        method: "POST",
        data: {
          anketaId: anketaId,
          novoPitanje: novoPitanje,
          btnIzmeniAnketu: true
        },
        success: function (data) {
          $('#izmeniPitanjePoruke').html(`<p class="text-success">${data.poruka}</p>`);

        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);
          let html = "";
          obj.greske.forEach(element => {
            html += `<p class="text-danger">${element}</p>`;
          });
          $('#izmeniPitanjePoruke').html(html);
        }
      });

    });

    $('#btnIzmeniOdgovor').click(function () {

      let izabraniOdgId = $('#odgovoriDdl').val();
      let noviOdgovor = $('#noviOdgovor').val();

      $.ajax({
        url: "models/admin/izmeniOdgovore.php",
        method: "POST",
        data: {
          odgId: izabraniOdgId,
          noviOdg: noviOdgovor,
          btnIzmeniOdgovor: true
        },
        success: function (data) {
          $('#izmeniOdgovorPoruke').html("");
          $('#izmeniOdgovorPoruke').html(`<p class="text-success">${data.poruka}</p>`);

        },
        error: function (xhr) {
          $('#izmeniOdgovorPoruke').html("");
          let obj = JSON.parse(xhr.responseText);
          let html = "";
          obj.greske.forEach(element => {
            html += `<p class="text-danger">${element}</p>`;
          });
          $('#izmeniOdgovorPoruke').html(html);
        }
      });

    });

    $('#btnBanuj').click(function () {
      let korisnik = $('#korisnici').val();
      $.ajax({
        url: "models/admin/banujKorisnika.php",
        method: "POST",
        data: {
          korisnik: korisnik,
          btnBanuj: true
        },
        success: function (data) {
          $('#greskePretraga').html(`<p class="text-success">${data.poruka}</p>`);
        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);
          $('#greskePretraga').html(`<p class="text-danger">${obj.poruka}</p>`);
        }
      });

    });
    $('#btnUloga').click(function () {
      let korisnik = $('#korisnici').val();
      let uloga = $('#uloga').val();
      $.ajax({
        url: "models/admin/dodeliUlogu.php",
        method: "POST",
        data: {
          korisnik: korisnik,
          ulogaId: uloga,
          btnPromeniUlogu: true
        },
        success: function (data) {
          $('#greskePretraga').html("");
          $('#greskePretraga').html(`<p class="text-success">${data.poruka}</p>`);

        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);

          $('#greskePretraga').html("");
          $('#greskePretraga').html(`<p class="text-danger">${obj.poruka}</p>`);
        }
      });
    });

    $('#btnAktivirajAnketu').click(function () {
      let anketaId = $('#upravljanjeAnketamaDdl').val();

      $.ajax({
        url: "models/admin/upravljanjeAnketama.php",
        method: "POST",
        data: {
          anketaId: anketaId,
          btnAktivirajAnketu: true
        },
        success: function (data) {
          $('#upravljajAnketamaPoruke').html("");
          $('#upravljajAnketamaPoruke').html(`<p class="text-success">${data.poruka}</p>`);

          reload();

        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);

          $('#upravljajAnketamaPoruke').html("");
          $('#upravljajAnketamaPoruke').html(`<p class="text-danger">${obj.poruka}</p>`);
        }
      });

    });

    $('#btnUkloniAnketu').click(function () {
      let anketaId = $('#upravljanjeAnketamaDdl').val();

      $.ajax({
        url: "models/admin/upravljanjeAnketama.php",
        method: "POST",
        data: {
          anketaId: anketaId,
          btnUkloniAnketu: true
        },
        success: function (data) {
          $('#upravljajAnketamaPoruke').html("");
          $('#upravljajAnketamaPoruke').html(`<p class="text-success">${data.poruka}</p>`);
          reload();
        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);

          $('#upravljajAnketamaPoruke').html("");
          $('#upravljajAnketamaPoruke').html(`<p class="text-danger">${obj.poruka}</p>`);
        }
      });

    });

    $('#btnDeaktivirajSveAnkete').click(function () {
      $.ajax({
        url: "models/admin/upravljanjeAnketama.php",
        method: "POST",
        data: {
          btnDeaktivirajSveAnkete: true
        },
        success: function (data) {
          $('#upravljajAnketamaPoruke').html("");
          $('#upravljajAnketamaPoruke').html(`<p class="text-success">${data.poruka}</p>`);
          reload();
        }
      });

    });

    $('#upravljanjeKategorijamaDdl').change(function () {
      let katId = $(this).val();

      $.ajax({
        url: "models/admin/podesavanjeKategorije.php",
        method: "POST",
        data: {
          katId: katId,
          ddlKatPromena: true
        },
        success: function (data) {
          let roditelj = data.kategorija.roditelj_id;
          $('#kategorijePoruke').html("");

          $('#novoImeKat').attr("value", data.kategorija.kategorija_naziv);
          if (roditelj != null) {
            $('#upravljanjeRodKategorijamaDdl').val(roditelj);
          }
          else {
            $('#upravljanjeRodKategorijamaDdl').val("");
          }
        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);
          $('#kategorijePoruke').html(`<p class="text-danger">${obj.poruka}</p>`);
          $('#novoImeKat').attr("value", obj.tekst);
        }
      });
    });

    $('#btnIzmeniKategoriju').click(function () {
      let novoImeKat = $('#novoImeKat').val();
      let novaRodKat = $('#upravljanjeRodKategorijamaDdl').val();
      let kategorija = $('#upravljanjeKategorijamaDdl').val();
      let greske = 0;
      if ($("#upravljanjeKategorijamaDdl option:selected").text() == novoImeKat && $('#upravljanjeKategorijamaDdl option:selected').data('rod') == $('#upravljanjeRodKategorijamaDdl option:selected').val()) {
        $('#izmeniKatPoruke').html('<p class="text-danger">Morate izmeniti bar jednu stavku.</p>');
        ++greske;
      }
      else if (kategorija == '') {
        $('#izmeniKatPoruke').html('<p class="text-danger">Morate izabrati kategoriju.</p>');
        ++greske;
      }
      else if (novaRodKat == kategorija) {
        $('#izmeniKatPoruke').html('<p class="text-danger">Kategorija ne moze biti roditelj sama sebi.</p>');
        ++greske;
      }
      if (greske == 0) {
        $.ajax({
          url: "models/admin/podesavanjeKategorije.php",
          method: "POST",
          data: {
            kategorija: kategorija,
            novaRodKat: novaRodKat,
            novoImeKat: novoImeKat,
            btnIzmeniKategoriju: true
          },
          success: function (data) {
            $('#izmeniKatPoruke').html(`<p class="text-success">${data.poruka}</p>`);

          },
          error: function (xhr) {
            let greske = JSON.parse(xhr.responseText);
            let html = '';
            for (let greska of greske.greske) {
              html += `<p class="text-danger">${greska}</p>`;
            }
            $('#izmeniKatPoruke').html(html);
          }
        });
      }

    });

    $('#btnUkloniKategoriju').click(function () {
      let katZaBrisanje = $('#upravljanjeKategorijamaDdl').val();
      $.ajax({
        url: "models/admin/podesavanjeKategorije.php",
        method: "POST",
        data: {
          katZaBrisanje: katZaBrisanje,
          btnUkloniKategoriju: true
        },
        success: function (data) {
          $('#upravljajKategorijamaPoruke').html(`<p class="text-success">${data.poruka}</p>`);
          reload();
        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);

          $('#upravljajKategorijamaPoruke').html(`<p class="text-danger">${obj.poruka}</p>`)
        }
      });

    });



    $('#btnKreirajNovuKat').click(function () {
      let imeKat = $('#tbNovaKat').val();
      let roditeljId = $('#novaKatRodDdl').val();
      $.ajax({
        url: "models/admin/kreirajKategoriju.php",
        method: "POST",
        data: {
          imeKat: imeKat,
          roditeljId: roditeljId,
          btnKreirajNovuKat: true
        },
        success: function (data) {
          $('#kreirajKategorijuPoruke').html(`<p class="text-success">${data.poruka}</p>`);
        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);
          $('#kreirajKategorijuPoruke').html(`<p class="text-danger">${obj.poruka}</p>`)
        }
      });
    });
    $('#podesavanjaLinka').hide();
    $('#upravljanjeLinkovima').change(function () {
      $('#podesavanjaLinka').hide();
    });
    $('#btnIzmeniLink').click(function () {
      let linkId = $('#upravljanjeLinkovima').val();
      $.ajax({
        url: "models/admin/izmeniLink.php",
        method: "POST",
        data: {
          linkId: linkId,
          btnIzmeniLink: true
        },
        success: function (data) {
          $('#podesavanjaLinka').show();
          $('#tbLinkTekst').val(data.link_tekst);
          $('#tbHref').val(data.href);
          $('#tbTitle').val(data.title);
          $('#prioritet').val(data.redosled);
        },
        error: function (xhr) {
          $("#navigacijaPoruke").html('<p class="text-danger">Morate izabrati link.</p>');
          $('#podesavanjaLinka').hide();
          $('#tbLinkTekst').val("");
          $('#tbHref').val("");
          $('#tbTitle').val("");
          $('#prioritet').val("");
        }
      });

    });

    $('#btnUkloniLink').click(function () {
      let linkId = $('#upravljanjeLinkovima').val();
      $.ajax({
        url: "models/admin/izmeniLink.php",
        method: "POST",
        data: {
          linkId: linkId,
          btnUkloniLink: true
        },
        success: function (data) {
          console.log(data);
          $("#navigacijaPoruke").html(`<p class="text-success">${data.poruka}</p>`);
        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);
          $("#navigacijaPoruke").html(`<p class="text-danger">${obj.poruka}</p>`);
        }
      });

    });

    $('#btnSacuvajIzmeneLink').click(function () {
      let linkTekst = $('#tbLinkTekst').val();
      let href = $('#tbHref').val();
      let title = $('#tbTitle').val();
      let prioritet = $('#prioritet').val();
      let id = $('#upravljanjeLinkovima').val();
      $.ajax({
        url: "models/admin/izmeniLink.php",
        method: "POST",
        data: {
          id: id,
          linkTekst: linkTekst,
          href: href,
          title: title,
          prioritet: prioritet,
          btnSacuvajIzmeneLink: true
        },
        success: function (data) {
          $("#navigacijaPoruke").html(`<p class="text-success">${data}</p>`);

        },
        error: function (xhr) {
          $('#navigacijaPoruke').html(xhr.responseText);
        }
      });
    });

    $('#btnKreirajNoviLink').click(function () {
      let linkTekst = $('#tbNoviLinkTekst').val();
      let href = $('#tbLinkHref').val();
      let title = $('#tbLinkTitle').val();
      let prioritet = $('#numPrioritet').val();

      $.ajax({
        url: "models/admin/kreirajLink.php",
        method: "POST",
        data: {
          linkTekst: linkTekst,
          href: href,
          title: title,
          prioritet: prioritet,
          btnKreirajNoviLink: true
        },
        success: function (data) {
          $("#navigacijaPoruke").html(`<p class="text-success">${data}</p>`);
        },
        error: function (xhr) {
          let obj = JSON.parse(xhr.responseText);
          $("#navigacijaPoruke").html(`<p class="text-danger">${obj}</p>`);
        }
      });

    });

  }
  else if (location.includes("urediVest.php?id")) {
    $('#btnObrisiVest').click(function () {
      let vestId = $(this).data('vestid');
      $.ajax({
        url: "models/urednik/obrisiVest.php",
        method: "POST",
        data: {
          vestId: vestId,
          btnObrisiVest: true
        },
        success: function (data) {
          window.location.href = "autorVesti.php";
        }
      });
    })

  }
  else if (location.includes("vest.php?vestId=")) {
    vestId = $('#idV').val();

    setTimeout(function () {
      $.ajax({
        url: "models/korisnik/vestProcitana.php",
        method: "POST",
        data: {
          vestId: vestId,
          vestProcitana: true
        }
      });
    }, 10000);
    $('#replyingTo').hide();

    $(document).on('click', '.comment-reply-link', function () {
      let komId = $(this).data('komentarid');
      let replyingTo = $(this).data('username');
      $('#btnKomentarisi').attr('data-reply', komId);
      $('#replyingTo').show()
      $('#replyInfo').text(`Replying to: ${replyingTo}`);

    });

    $('#reply-remove').click(function (e) {
      e.preventDefault();
      $('#btnKomentarisi').attr('data-reply', "");
      $('#replyingTo').slideToggle();
    });

    $('#btnKomentarisi').click(function () {
      let komentar = $('#comment').val();
      let komentarRod = $(this).attr('data-reply');
      $.ajax({
        url: "models/korisnik/komentarisi.php",
        method: "POST",
        data: {
          vestId: vestId,
          komentar: komentar,
          komentarRod: komentarRod,
          btnKomentarisi: true
        },
        success: function (data) {
          $('#vest-komentari').html(data.komentari);
          $('#brKomentara').html(data.brKomentara + " Komentara");
          $('#btnKomentarisi').attr('data-reply', "");
          $('#comment').val("");

          $('#replyingTo').hide();
        }
      });
    });
    $(document).on('click', '.comment-remove-link', function (e) {
      e.preventDefault();
      let idKomentara = $(this).data('idzabrisanje');

      $.ajax({
        url: "models/korisnik/ukloniKomentar.php",
        method: "POST",
        data: {
          vestId: vestId,
          komentar: idKomentara,
          obrisiKomentar: true
        },
        success: function (data) {
          console.log(data);
          $('#vest-komentari').html(data.komentari);
          $('#brKomentara').html(data.brKomentara + " Komentara");
        },
        error: function (xhr) {
          console.log(xhr);
        }
      });
    });
  }
  else if (location.includes("vesti.php")) {

    let linkovi = $('.link-kat');
    linkovi.click(function (e) {
      e.preventDefault();
      let kategorija = $(this).data('kategorija');
      $.ajax({
        url: "models/korisnik/vestiKategorije.php",
        method: "POST",
        data: {
          katId: kategorija,
          prikaziVesti: true
        },
        success: function (data) {
          let brStranica = data.brojStranica;
          let stranice = "";
          for (let i = 1; i <= brStranica; ++i) {
            stranice += `<a class="page-numbers stranica" data-kategorija="${data.katId}" data-stranica="${i}" href="#"><span class="meta-nav screen-reader-text">Stranica </span>${i}</a>`
          }
          $('#stranice').html(stranice);
          let html = "";
          for (let vest of data.vesti) {
            html += `<div class="col-12 col-lg-12 col-md-6 col-sm-6 blog-paralle">
            <div class="type-post">
                <div class="entry-cover">
                    <div class="post-meta">
                        <span class="post-date">${vest.datum}</span>
                    </div>
                    <a href="vest.php?vestId=${vest.vest_id}"><img src="assets/images/slikeVesti/${vest.slika_sm}" alt="${vest.slika_alt}" /></a>
                </div>
                <div class="entry-content">
                    <div class="entry-header">	
                        <span class="post-category">${vest.kategorija_naziv}</span>
                        <h3 class="entry-title"><a href="vest.php?vestId=${vest.vest_id}" title="${vest.vest_naslov}">${vest.vest_naslov}</a></h3>
                    </div>								
                    <p>${vest.tekst}</p>
                </div>
            </div>
        </div>`;
          }
          $('#sveVesti').html(html);
          $('.stranica').click(function (e) {
            e.preventDefault();
            let stranica = $(this).data('stranica');
            let kategorija = $(this).data('kategorija');
            $.ajax({
              url: "models/korisnik/promeniStranicu.php",
              method: "POST",
              data: {
                kategorija: kategorija,
                limit: stranica,
                novaStranica: true
              },
              success: function (data) {
                let html = "";
                for (let vest of data) {
                  let datum =

                    html += `<div class="col-12 col-lg-12 col-md-6 col-sm-6 blog-paralle">
                  <div class="type-post">
                      <div class="entry-cover">
                          <div class="post-meta">
                              <span class="post-date">${vest.datum}</span>
                          </div>
                          <a href="vest.php?vestId=${vest.vest_id}"><img src="assets/images/slikeVesti/${vest.slika_sm}" alt="${vest.slika_alt}" /></a>
                      </div>
                      <div class="entry-content">
                          <div class="entry-header">	
                              <span class="post-category">${vest.kategorija_naziv}</span>
                              <h3 class="entry-title"><a href="vest.php?vestId=${vest.vest_id}" title="${vest.vest_naslov}">${vest.vest_naslov}</a></h3>
                          </div>								
                          <p>${vest.tekst}</p>
                      </div>
                  </div>
              </div>`;
                }
                $('#sveVesti').html(html);
              }
            });
          });
        }
      });
    });
    $('.stranica').click(function (e) {
      e.preventDefault();
      let stranica = $(this).data('stranica');
      let kategorija = $(this).data('kategorija');
      $.ajax({
        url: "models/korisnik/promeniStranicu.php",
        method: "POST",
        data: {
          kategorija: kategorija,
          limit: stranica,
          novaStranica: true
        },
        success: function (data) {
          let html = "";
          for (let vest of data) {
            html += `<div class="col-12 col-lg-12 col-md-6 col-sm-6 blog-paralle">
            <div class="type-post">
                <div class="entry-cover">
                    <div class="post-meta">
                        <span class="post-date">${vest.datum}</span>
                    </div>
                    <a href="vest.php?vestId=${vest.vest_id}"><img src="assets/images/slikeVesti/${vest.slika_sm}" alt="${vest.slika_alt}" /></a>
                </div>
                <div class="entry-content">
                    <div class="entry-header">	
                        <span class="post-category">${vest.kategorija_naziv}</span>
                        <h3 class="entry-title"><a href="vest.php?vestId=${vest.vest_id}" title="${vest.vest_naslov}">${vest.vest_naslov}</a></h3>
                    </div>								
                    <p>${vest.tekst}</p>
                </div>
            </div>
        </div>`;
          }
          $('#sveVesti').html(html);
        }
      });
    });
  }
  else if (location.includes('kontakt.php')) {
    $('#btnPosaljiMail').click(function () {
      let ime = $('#kontaktIme').val();
      let email = $('#kontaktEmail').val();
      let naslov = $('#kontaktNaslov').val();
      let poruka = $('#kontaktPoruka').val();
      let greske = [];

      let imeRe = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;
      let emailRe = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
      let naslovRe = /[A-Za-z\s?]+/;
      if (!imeRe.test(ime)) {
        greske.push("Ime mora početi velikim slovom i ne sme imati specijalne karaktere.");
      }
      if (!emailRe.test(email)) {
        greske.push("Email nije ispravno unet.");
      }
      if (!naslovRe.test(naslov)) {
        greske.push("Naslov ne sme da sadrži specijalne karaktere ili da ostane prazan.");
      }
      if (naslov.length < 5) {
        greske.push("Naslov ne sme da bude kraći od 5 karaktera.");
      }
      if (naslov.length > 30) {
        greske.push("Naslov mora da bude kraći od 30 karaktera.");
      }
      if (poruka == '') {
        greske.push("Poruka ne sme da ostane prazna.");
      }
      if (poruka.length > 350) {
        greske.push("Poruka ne sme da bude duza od 350 karaktera.");
      }

      if (greske.length == 0) {
        $.ajax({
          url: "models/korisnik/posaljiMail.php",
          method: "POST",
          data: {
            ime: ime,
            email: email,
            poruka: poruka,
            naslov: naslov,
            btnKontaktiraj: true
          },
          success: function (data) {
            $('#kontaktGreske').html(`<p class="text-success">${data.poruka}</p>`);
          },
          error: function (xhr) {
            let obj = JSON.parse(xhr.responseText);
            let greske = obj.greske;
            let html = "";
            for (let greska of greske) {
              html += `<p class="text-danger">${greska}</p>`;
            }
            $('#kontaktGreske').html(html);
          }
        });
      }
      else {
        let html = "";
        greske.forEach(element => {

          html += `<p class="text-danger">${element}</p>`;
        });
        $('#kontaktGreske').html(html);
      }
    });

  }
  else{
    $('#anketa').removeClass('d-flex');
    $('#anketa').hide();

    $('#reply-remove').click(function (e) {
      e.preventDefault();
      $('#anketa').removeClass('d-flex');
      $('#anketa').hide();
    });

    this.setTimeout(function () {
      $.ajax({
        url: "models/korisnik/anketa.php",
        method: "POST",
        data: {
          proveriAnketu: true
        },
        success: function (data) {
          if (!data.odradjeno) {
            let html = `
            <h2>${data.anketaPitanje.pitanje}</h2>
            <ul class="list-group m-5">`;
            for (let odg of data.anketaOdg) {
              html += `<li class="list-group-item pr-5 pl-5">
              <input type="radio" value="${odg.odgovor_id}" name="anketa">${odg.odgovor}
              </li>`;
            }
            html += `</ul>`;
            $('#anketaPitanje').html(html);
            $('#anketa').addClass('d-flex');
            $('#anketa').show();
            $('#btnOdradiAnketu').attr('data-anketaid', data.anketaPitanje.anketa_id);

            $('#btnOdradiAnketu').click(function () {
              let anketaOdg = $('input[name=anketa]:checked').val();
              let anketaid = $(this).data('anketaid');
              if (anketaOdg == undefined) {
                $('#anketaPor').html('<p class="text-danger">Morate izabrati odgovor</p>');
              }
              else {
                $.ajax({
                  url: "models/korisnik/uradiAnketu.php",
                  method: "POST",
                  data: {
                    anketaid: anketaid,
                    anketaOdg: anketaOdg,
                    btnUradiAnketu: true
                  },
                  success: function (data) {
                    $('#anketa').removeClass('d-flex');
                    $('#anketa').hide();
                  },
                  error: function (xhr) {
                    let obj = JSON.parse(xhr.responseText);
                    let html = "";
                    for (greska of obj.greske) {
                      html += `<p class="text-danger">${greska}</p>`;
                    }
                    $("#userMessage").html(html);
                  }
                });
              }
            });
          }
        }
      });
    }, 3000);
  }

});

function statistika() {
  $.ajax({
    url: "models/admin/statistika.php",
    method: "POST",
    data: {
      aktivnaAnketa: true
    },
    success: function (data) {
      var ctx = document.getElementById('myChart').getContext('2d');
      var chart = new Chart(ctx, {

        type: 'bar',

        data: {
          labels: data.nizOdgovora,
          datasets: [{
            label: 'Broj odgovora',
            backgroundColor: 'rgb(0, 0, 0)',
            hoverBackgroundColor: 'rgb(32, 32, 32)',
            borderColor: 'rgb(255, 255, 255)',
            data: data.nizGlasova
          }]
        },

        options: {}
      });

    }
  });
}
function reload() {
  setTimeout(function () {
    window.location.reload();
  }, 1000);
}