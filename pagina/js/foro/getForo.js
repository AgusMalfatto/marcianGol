var settings = {
    "url": "../../php/foro/getForo.php",
    "method": "GET",
    "timeout": 0,
    "data": {
        "id_foro": 2
    },
  };
  
  $.ajax(settings).done(function (response) {
    console.log(response);
  });