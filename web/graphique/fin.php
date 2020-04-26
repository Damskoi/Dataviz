<!-- PIED DE PAGE -->
<div class="footer col-sm-12">
  <div class="menu_footer offset-sm-2 col-sm-9">
    <!--<a class="nav-link" href="#">Accueil</a>
    <a class="nav-link" href="#">Le récit d'anticipation</a>
    <a class="nav-link" href="#">En graphique</a>-->
    <a class="nav-link" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#">L'ANR Anticipation</a>
    <a class="nav-link" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#">Principe de sélection des oeuvres</a>
    <a class="nav-link" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#">Les contributeurs</a>
    <a class="nav-link" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#">Signaler une erreur</a>
    <a class="nav-link" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#">Mentions légales</a>
  </div>
</div>
<!-- FIN PIED DE PAGE -->
</div>
<!-- FIN CONTENU DE LA PAGE -->
</div>
<!-- FIN WRAPPER -->
<a id="back-to-top" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#" class="btn btn-danger btn-lg back-to-top" role="button" title="" data-toggle="tooltip" data-placement="left" data-original-title="Click to return on the top page" style="display: inline;"><span class="glyphicon glyphicon-chevron-up"></span></a>


<!--  Menu Burger -->
<script type="text/javascript">
$(document).ready(function () {
  $("#sidebar").mCustomScrollbar({
    theme: "minimal"
  });

  $('#dismiss, .overlay').on('click', function () {
    $('#sidebar').removeClass('active');
    $('.overlay').fadeOut();
  });

  $('#sidebarCollapse').on('click', function () {
    $('#sidebar').addClass('active');
    $('.overlay').fadeIn();
    $('.collapse.in').toggleClass('in');
    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
  });
});
</script>
<!--  Couper les citations trop longues -->
<script type="text/javascript">
jQuery(function(){
  var minimized_elements = $('p.minimize');
  minimized_elements.each(function(){
    var t = $(this).text();
    if(t.length < 1000) return;
    $(this).html(
      t.slice(0,1000)+'<span>... </span><a href="#" class="more">  Lire la suite</a>'+
      '<span style="display:none;">'+ t.slice(1000,t.length)+' </br><a href="#" class="less" style="position: relative; z-index: 1000;">   Réduire</a></span>'
    );
  });
  $('a.more', minimized_elements).click(function(event){
    event.preventDefault();
    $(this).hide().prev().hide();
    $(this).next().show();
  });
  $('a.less', minimized_elements).click(function(event){
    event.preventDefault();
    $(this).parent().hide().prev().show().prev().show();
  });
});
</script>
<!--  SCROLLBACK -->
<script type="text/javascript">
$(document).ready(function(){
  $(window).scroll(function () {
    if ($(this).scrollTop() > 50) {
      $('#back-to-top').fadeIn();
    } else {
      $('#back-to-top').fadeOut();
    }
  });
  // scroll body to 0px on click
  $('#back-to-top').click(function () {
    // $('#back-to-top').tooltip('hide');
    $('body,html').animate({
      scrollTop: 0
    }, 800);
    return false;
  });

  // $('#back-to-top').tooltip('show');

});
</script>

<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
})
// Un peu de debuggage...

strTypeRecherche = 'bRechercheAvancee=1';
strRecherche = '';
</script>


<ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div>
<ul id="ui-id-2" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div>
<ul id="ui-id-3" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div>
<ul id="ui-id-4" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div><ul id="ui-id-5" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div><ul id="ui-id-6" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div><ul id="ui-id-7" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div>
<ul id="ui-id-8" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div>
<ul id="ui-id-9" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div><ul id="ui-id-10" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div><ul id="ui-id-11" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div><ul id="ui-id-12" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div>
<ul id="ui-id-13" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
<div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div>
</body>
</html>
