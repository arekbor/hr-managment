function initEmployeeSelect2(className, delay = 500) {
  $(className).each(function () {
    const config = {
      allowClear: true,
      width: "resolve",
      ajax: {
        data: function (params) {
          return { name: params.term };
        },
        dataType: "json",
        delay: delay,
        processResults: function (data) {
          const dataresults = [];
          $.each(data, function (key, val) {
            dataresults.push({ id: val["id"], text: val["name"] });
          });
          return { results: dataresults };
        },
      },
    };

    $(this).select2(config);
  });
}
