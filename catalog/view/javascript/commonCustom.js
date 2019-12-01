document.addEventListener('DOMContentLoaded', function () {
  const searchFront = () => {
    $('#search input[name=\'search\']').parent().find('button').on('click', function () {

      console.log('!!!');

      var url = $('base').attr('href') + 'index.php?route=product/search';

      var value = $('#search input[name=\'search\']').val();

      if (value) {
        url += '&search=' + encodeURIComponent(value);
      }

      location = url;
    });

    $('#search input[name=\'search\']').on('keydown', function (e) {
      if (e.keyCode == 13) {
        $('#search input[name=\'search\']').parent().find('button').trigger('click');
      }
    });
  }


  const searchButton = document.getElementById('test');
  const place = document.getElementById('top-links');
  const elem = document.createElement(`div`);

  elem.innerHTML = search;
  searchButton.addEventListener('click', () => {
    place.append(elem);
    searchFront
  });
}, false);


