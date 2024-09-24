jQuery(document).ready(function ($) {
  var artwork = 0;
  var dropZone = $("#drag-and-drop-zone");

  dropZone.on("dragover", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).addClass("dragover");
  });

  dropZone.on("dragleave", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).removeClass("dragover");
  });

  dropZone.on("drop", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).removeClass("dragover");

    var files = e.originalEvent.dataTransfer.files;
    if ($("#copyright_art_ar").is(":checked")) {
      handleFiles(files);
    } else {
      alert("Please check the checkbox first!!");
    }
  });

  $("#drag-and-drop-zone").on("change", "#file-input", function (e) {
    var filesr = this.files;
    if ($("#copyright_art_ar").is(":checked")) {
      if (this.files[0].size > 5242880) {
        alert("File size should be less than 5 MB");
      } else {
        handleFiles(filesr);
      }
    } else {
      alert("Please check the checkbox first!!");
    }
  });
  jQuery("#closerdrop_ar").on("click", function (e) {
    jQuery(".drag_drop_zone_wrapper").css("display", "none");
  });
  jQuery("#copyright_art_ar").on("click", function (e) {
    if ($("#copyright_art_ar").is(":checked")) {
      jQuery("#file-input").removeAttr("disabled");
    } else {
      jQuery("#file-input").attr("disabled", "disabled");
    }
  });
  function handleFiles(files) {
    jQuery("#loader_mi_ar").css("display", "flex");
    var id = jQuery(".drag_drop_zone_wrapper").attr("classtoadd");
    var iid = `#${id}`;
    var formData = new FormData();
    $.each(files, function (i, file) {
      formData.append("files[]", file);
    });

    formData.append("action", "file_upload");

    $.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        response = JSON.parse(response);

        if (response.uploaded.length > 0) {
          $.each(response.uploaded, function (index, url) {
            jQuery(iid).find("img").attr("src", url);
          });
          jQuery(".drag_drop_zone_wrapper").css("display", "none");
          jQuery("#loader_mi_ar").css("display", "none");
        }

        if (response.failed.length > 0) {
          $.each(response.failed, function (index, error) {
            uploadStatus.append("<p>Error: " + error + "</p>");
          });
        }
      },
    });
  }

  jQuery(".allprintareas").on("click", ".size_name_upload", function () {
    console.log("artwork", artwork);
    jQuery(".drag_drop_zone_wrapper").attr("classtoadd", `input_ar_${artwork}`);
    jQuery(".drag_drop_zone_wrapper").find("input[type='file']").val("");
    jQuery(this).attr("id", `input_ar_${artwork}`);
    jQuery(".drag_drop_zone_wrapper").css("display", "flex");
    artwork = artwork + 1;
  });
});
