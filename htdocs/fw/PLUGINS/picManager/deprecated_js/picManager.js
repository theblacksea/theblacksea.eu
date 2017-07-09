
var picsNr = 3;
var firstPic_id;       //  = "pic_"[id] - id-ul ultimului / primului span (>img)
var lastPic_id;        // utile pentru comparatii de sfarsit de galerie

var first_pozPic=0;    //  - indexul primei poze din seria vizibila
var countNew = 0;

var JQcar;            //selectia carouselul JQobj
var JQcar_picDet;     // JQ selection picture details

/*===================================[ Rolling carousel ]=================================================*/

/**
 * ACTION on:  .image_carousel .carousel-content span.thumbPic-manager
 * RESULTS:
 *      - arata urmatoarele 3 poze + display: none pe precedentele poze
 *      - pozitioneaza detaliile pozei pe prima din serie
 *      - calculeaza daca mai sunt poze de afisat
 *          - daca nu mai sunt disable pe butonul de next
 */
function nextPic(){

    var el={}, id={};

    // last pic in the shown pics
    el.lastPic = $('.image_carousel .carousel-content *[class$=showPic]').last();
    id.pic     = el.lastPic.attr('id');

    var onlyId = id.pic.split('_')[1];
    showPic_details(onlyId);
    // alert('nextPic-details = '+onlyId +' id.pic = '+id.pic+' lastid.pic = '+lastPic_id);

    if(id.pic != lastPic_id)
    {
        first_pozPic +=3;

        /*=============================[ show next pics]==============================================*/

        el.lastPic.prevAll().removeClass('showPic');

        el.nextall = el.lastPic.nextAll().slice(0,3);
        el.nextall.addClass('showPic');

        /*=============================[ prev - next buttons]==============================================*/
        id.set_lastpic = el.nextall.last().attr('id');
        if(id.set_lastpic == lastPic_id)
            $('.image_carousel #cars_next').addClass('disabled');

        $('.image_carousel #cars_prev').removeClass('disabled');

    }


}
function prevPic(){

    var el={}, id={};

    // first pic in the shown pics
    el.firstPic = $('.image_carousel .carousel-content .showPic').first();

    id.pic = el.firstPic.attr('id');
    showPic_details(id.pic.split('_')[1]);

    if(id.pic != firstPic_id)
    {
        first_pozPic -=3;
        /*=============================[ show prev pics]==============================================*/

        el.firstPic.nextAll().removeClass('showPic');
        el.prevAll = el.firstPic.prevAll().slice(0,3);
        el.prevAll.addClass('showPic');

        /*=============================[ prev - next buttons]==============================================*/
        id.set_firstpic = el.prevAll.last().attr('id');
        if(id.set_firstpic == firstPic_id)
            $('.image_carousel #cars_prev').addClass('disabled');

        $('.image_carousel #cars_next').removeClass('disabled');
    }




}

/**
 * RESULT: show pics details  ACTION on: .ENT #[pic-full_{~idPic}_en]
 * @param pic_id - idPic
 *
 * LOGISTICS:
 *  - ascunte toate pozele detaliate
 *  - arata doar pe cea ceruta
 */
function showPic_details(pic_id){

    //alert(pic_id);
    $('.pics-Details .pic-full').hide();
    $('.pics-Details *[id^=pic-full_'+pic_id+'_]').show();
}



/*===================================[ INI carousel ]=================================================*/
/**
 * ACTION on: BTNS:next, prev , PIC - span.thumbPic-manager
 */
function carouselBinds(){


    $('.image_carousel #cars_next').live('click', function(){ nextPic(); return false; });
    $('.image_carousel #cars_prev').live('click', function(){ prevPic(); return false; });
    $('.image_carousel .thumbPic-manager')
        .live('click', function(){
            //alert('am dat click pe imagine - carouselBinds');
            var pic_id = $(this).attr('id').split('_')[1];
            showPic_details(pic_id);
            return false;
        });
}

/**
 * SET: firstPic_id / lastPic_id  ACTIon: BTN next, picDetails
 *
 * @param startFrom - index from where to start
 * @param showPic   - for pic-details
 */
function carouselStart(startFrom, showPic){

//alert('carouselStart');
    var el = {};
    var stopAt_index = startFrom +4;

    el.thumbPic_manager =  $('.image_carousel .carousel-content .thumbPic-manager');

    //=========================[ ]================================================================================

    el.thumbPic_manager.slice(startFrom,stopAt_index)
                            .addClass('showPic');

    firstPic_id = el.thumbPic_manager.first().attr('id');
    lastPic_id  = el.thumbPic_manager.last().attr('id');
   // alert('firstPic_id = '+firstPic_id+'\n lastPic_id = '+lastPic_id);


    //===========[ BTN next ]======================================================================================
    if($('.image_carousel .carousel-content *[class$=showPic]').last().next().length > 0)
         $('.image_carousel #cars_next').removeClass('disabled');
    else
        $('.image_carousel #cars_next').addClass('disabled');

    //=========================[pic- details ]================================================================================
    if(showPic == '')
           showPic = firstPic_id.split('_')[1];
    showPic_details(showPic);

}

/**
 * RESTART for: adding pics, deletings pics
 * @param startFrom
 * @param showPic
 */
function carouselRestart(startFrom, showPic){

    $('.image_carousel .carousel-content *[class$=showPic]').removeClass('showPic');
    carouselStart(startFrom, showPic);
}

/**
 * Becaouse binds should be made only once
 */
function carousel_firstStart(){

    carouselStart(0,'');

    carouselBinds();


}



/*===================================[ Managing pictures ]=================================================*/

/**
 * USED BY: editMODE RESULT: delete pic from craousel and pic-details, restart carousel
 * @param Name
 * @param id
 */
function carousel_deletePic(Name, idPic){
    /**
     * LOGISTICS
     *
     *
     *  restartCarousel = true / false  - daca sa se restarteze carouselul sau nu
     *  id.pic =
     *  id.showPic = id-ul pozei din pic-details
     *  deletePic  = [obj] selectia pozei ce urmeaza sa fie deletata
     *
     *  first_pozPic = prima poza vizibila din setul curent, indexul ei in cadrul tuturor pozelor
     *  startFrom   = resetam startFrom al carouselului
     *
     *  ----[ MODIFICARE poza detaliata ]----------------
     *
     *  - se incearca selectarea primei poze dupa cea deletata
     *  - daca nu exista
     *      - se incearca selectarea precedentei
     *          - daca precedenta are display = none si prima poza din set nu are indexul = 0
     *              - trebuie sa ne intoarcem cu un set in urma
     *
     *      - daca nici o poza precedenta nu mai exista
     *          - inseamna ca cea deletata era unica deci nu trebuie resetat carouselul
     *
     *  ----[ Finalizare ]----------------------------------
     *
     *  - stergerea efectiva a pozei
     *  - resetarea carouselului
     *
     */

     var id = {};
     var el = {};
     var vr = {};

     vr.restartCarousel = true;
     vr.startFrom       = first_pozPic;

     id.pic        = 'pic_'+idPic;
     el.deletedPic = $('.image_carousel .carousel-content *[class^=thumbPic-manager][id='+id.pic+']');

    alert('In carousel_deletePic '+ 'id = '+id.pic+' first_pozPic ='+first_pozPic);


    //=================================[ determina poza din details- picture ]======================================
     id.showPic = '';

     el.nextPic = el.deletedPic.next();
     if(el.nextPic.length > 0)
     {
         id.showPic = el.nextPic.attr('id').split('_')[1];
     }
     else
     {
         el.prevPic = el.deletedPic.prev();
         if(el.prevPic.length > 0)
         {
             id.showPic = el.prevPic.attr('id').split('_')[1];
             /*inseamna ca trebuie sa ne ducem inspate deoarece toate pozele din setul actual s-au terminat*/
             if(el.prevPic.css('display')=='none' && first_pozPic!=0)
                 vr.startFrom -= 3;
         }
         else{
             /*inseamna ca e ultima poza din show deci nu prea am de ce sa restartez nimic*/
             alert("nu-i a buna in carousel_deletePic");
             vr.restartCarousel = false
         }
     }
     //===============================================================================================================

      alert('showPic_id = '+ id.showPic);

     // sterge poza
     el.deletedPic.remove();
      if(vr.restartCarousel)
         carouselRestart(vr.startFrom, id.showPic);


   }

/**
 * CALLEDBACK by: kcfinder - openKCFinder_popUp()  | RESULT : add pic in carousel & pic-details + add in BD via 'PLUGINS/picManager/ADMIN/addPic.php
 * @param url - provided by kcfinder
 */
function carousel_addPic(url){

    /**

     *
     *  - STEPS :
     *
     *  0. trimis datele spre .php pentru salvare
     *  1. am adaugat thumbnailul in carousel la inceputul lui
     *  2. adaug si poza mare in cadrul pics-Details
     *  3. call editMode spec pe el
     *  4. restartez carouselul de la inceput cu poza noua pe detaliu
     *  5. incrementez caouterul de poze noi adaugate
     *
     *
     *
     *   working model
     *   <div class=' uploaded_pics well hidden  container-fluid p10'
     *          id='".$this->picManager->DB_extKey_name."_".$this->picManager->DB_extKey_value."'>
     *   ex: id= idRecord_[idRecordValue]
     * */

    var statPic = $("div#kcfinder_div_selPic span img[src^='"+url+"']").length;
    // poza nu este inca adaugata
    if(statPic > 0)
    {
        alert('Your pic is already added !!!');
    }
    else
    {
        var idRecord = $('div[class^=uploaded_pics]').attr('id');
       // alert('idRecord '+idRecord);
        $.post
        (
            procesSCRIPT_file,

            {
                parsePOSTfile : 'PLUGINS/picManager/ADMIN/addPic.php',
                urlPic : url,
                idRecord : idRecord
            },

            function(data)
            {
                     // data este affected_rows
                 if(typeof data!='undefined')
                 {
                    var idPic = data;
                     //alert('idPic '+idPic);

                    //================================[ carousel adding ]===========================================
                    $('div#kcfinder_div_selPic')
                        .prepend(
                                 "<span class='thumbPic-manager' id='pic_"+idPic+"'>" +
                                     "<img src='"+url+"'  />" +
                                     "<small style='position: absolute;'> idPic = pic_"+idPic+"</small>" +
                                "</span> "
                                );

                    //================================[ pics-Details adding ]===========================================
                    $('.pics-Details')
                        .prepend(
                        "<div class='ENT pic-full' id='pic-full_"+idPic+"_en'>"+

                                        "<div class='big-picture'>"+
                                            "<img src='"+url+"'  />"+
                                        "</div>"+

                                        "<small><b>Title </b><span class='EDtxt picTitle'></span></small>"+
                                        "<br>"+
                                        "<small><b>Description </b><span class='EDtxa picDescr'></span></small>"+
                                        "<br>"+
                                        "<p class='muted t10 pic-specs'>"+
                                            "<small class='r10' ><b>Author</b> <span class='EDtxt picAuth'></span></small>"+
                                            "<small class='r10' ><b>Location</b> <span class='EDtxt picLoc'></span></small>"+
                                            "<small class='r10' ><b>Date</b> <span class='EDdate picDate'></span></small>"+
                                        "</p>"+
                            "</div>"
                    );

                    //==============================[ final touches ]======================================================

                    spec_EditMode('ENT','pic-full', idPic);

                    carouselRestart(0,'');

                    countNew++;
                   alert('carousel_addPic '+url +'a fost adaugata in BD cu id-ul '+ idPic);
                 }

                 else
                    alert('carousel_addPic '+url +'Nu a fost adaugata in BD');
            }
        );

    }
 }

/**
 * USED by: editMode | RESULT: se incearca adaugarea de detalii in cadrul ckeditor
 * @param Name
 * @param id
 */
function carousel_savePic(Name, id){

    var srcPic = JQcar_picDet.find('*[id^=pic-full_'+id+'] img')
                                    .attr('src');

   // alert('carousel_savePic '+srcPic);
    add_picDetail(srcPic, true);
}


/*===================================[Call popUp]=====================================================================*/

function openKCFinder_popUp(){
    window.KCFinder = {
           callBack: function(url) {
            //field.value = url;
            alert(url);
            carousel_addPic(url);  // carrousel callback function
            popUp_remove();
            window.KCFinder = null;
        }
    };

    popUpKCF = new popUp_call(
                { content:
                    "<div id='kcfinder_div'>" +
                        '<iframe name="kcfinder_iframe" src="/fw/GENERAL/core/js/kcfinder/browse.php?type=images" ' +
                                'frameborder="0" width="100%" height="100%" marginwidth="0" marginheight="0" scrolling="no" />'+
                    "</div>",

                    widthPop:'900',
                    heightPop : '450'
                });


}

/*===================================[ pic details- for recordContent]=================================================================================*/

/**
 * RESULT: get HTML_picDetails with src
 * @param src
 * @return {String}
 */
function get_picDetails(src){
    //=======================[DETALIILE POZEI ]=======================================
    var picDetails_stat = JQcar_picDet.find('.pic-full img[src="'+src+'"]');

    if(picDetails_stat.length > 0)
    {
        var picDetails = picDetails_stat.parents('.pic-full');

        var title = picDetails.find('*[class$=picTitle]').text();
        var descr = picDetails.find('*[class$=picDescr]').text();
        var auth  = picDetails.find('*[class$=picAuth]').text();
        var date  = picDetails.find('*[class$=picDate]').text();
        var loc   = picDetails.find('*[class$=picLoc]').text();

        title =(title!='' ? "<span style='margin: 1px 0px; padding: 0px;'> <strong>"+title+"</strong></span>" : '');
        descr =(descr!='' ? "<p style=' padding: 0px;'> "+descr+"</p>" : '');
        auth  =(auth !='' ? "<span class='muted' > <strong>Author </strong>"+auth +"</span>" : '');
        date  =(date !='' ? "<span class='muted'> <strong>Date </strong>"+date +"</span>" : '');
        loc   =(loc  !='' ? "<span class='muted' > <strong>Loc  </strong>"+loc  +"</span>" : '');


        var content ="<div class='picDetails' style='background: #f5f5f5; padding:3px; font-size: 0.83em;'>"+
                        "<button class='togglePicDetails icon-chevron-down' style='border:1px; float: right;'> " +
                        " </button>"+
                        title+

                        "<div class='more-picDetails'>"+
                                descr+
                                auth +
                                date +
                                loc  +
                        "</div>"+
                    "</div>"
        ;
    }
    else
      var content = "";

    return content;

}

/**
 * RESULT: adauga detalii unei poze adaugate cu KCFinder sau modificata de picManager
 *
 * @param src       - url-ul pozei
 * @param keepStyle - true sau false daca sa pastreze styleul containerului in care este poza
 *                    din continutul articolului
 *
 * STEPS:
 *  - daca se gaseste in continutul ckeditor o poza cu src-ul trimis
 *  - incearca sa preia detalii despre aceasta
 *      - daca poza are deja detalii adaugate
 *          - daca keepstyle => atunci se pastreaza styleul parintelui
 *          - se stripuieste poza
 *      - se incadreaza si i se adauga detaliile
 */
function add_picDetail(src, keepStyle){

    // deoarece src-ul care imi vine din cke - image.js este cu stringul acela inutil
    // deci mare problema replaceul trebuie luat deundeva altfel e belea
    src = src.replace('http://local.blacksea.eu','');
    src = src.replace('http://zero.blacksea.eu','');


   //==================================================================================
    var currIframe = $('iframe.cke_wysiwyg_frame').contents();
    var pic        = currIframe.find("img[src='"+src+"']");

    if(pic.length > 0)
    {
        var picDetails = get_picDetails(src);
        if(picDetails !='')
        {
            var picParent = pic.parent('.picFull');
            var stylePic  = pic.attr('style');

            if(picParent.length > 0)
            {
               if(keepStyle)
                    stylePic = picParent.attr('style');
               pic.unwrap();
               pic.next('.picDetails').remove();
            }



            pic.replaceWith(
                "<div class='picFull' style='"+stylePic+" border: 1px solid #ddd; height: initial;'>" +
                      "<img style='width:inherit;' src='"+src+"'>" +
                       get_picDetails(src)+
                "</div>"

            );
        }
    }
    else
        alert('nu s-a gasit nici o poza cu selectorul in editorul curent '+"img[src='"+src+"']");
                   //alert('Am terminat de adaugat poza '+this.imageElement+'\n'+this.originalElement.$.src );
}


$(document).ready(function(){

    $('button#callKCFinder').live('click',function(){
        //alert('Am apasat callKCFinder');
        openKCFinder_popUp();
        return false;
    });

    JQcar = $('.uploaded_pics');
    JQcar_picDet = JQcar.find('.pics-Details');
});

