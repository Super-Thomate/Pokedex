$(".types").on('click', function () {
  let status                 = this.dataset.status ;
  let img                    = $(this).find ('img')[0] ;
  let id                     = this.id ;
  let src                    = img.src ;
  let allTypes               = $('#hi_types').val().split("|") ;
  if (status == "unselected") {
    src                      = "/img/types/"+id+".png" ;
    status                   = "selected" ;
    allTypes         [allTypes.length] = id ;
    allTypes                 = allTypes.filter (function (type) {
      return type.length ;
    }) ;
  } else if (status == "selected") {
    src                      = "/img/types/"+id+"_unselected.png" ;
    status                   = "unselected" ;
    allTypes                 = allTypes.filter (function (type) {
      return (type != id && type.length) ;
    }) ;
  } else {
    console.error ("Error : unknown status") ;
  }
  img.src                    = src ;
  this.dataset.status        = status;
  $('#hi_types').val(allTypes.join("|")) ;
}) ;
$(".generation").on('click', function () {
  let that                   = $(this) ;
  if (that.hasClass('badge-secondary')) {
    that.removeClass('badge-secondary').addClass('badge-success') ;
  } else {
    that.removeClass('badge-success').addClass('badge-secondary') ;
  }
}) ;
