jQuery(document).ready(function () {
    navigator.permissions.query({ name: "clipboard-write" }).then((result) => {
        if (result.state == "granted" || result.state == "prompt") {
            alert("Write access ranted!");
        }
    });

    var Dtable = jQuery('#example').DataTable({
        ajax: {
            url: '/api', type: 'GET',
            dataSrc: function (d) {
                return d
            }
        },
        columns: [{ data: "originalURL" }, { data: "frequency" }],
        "order": [[1, "desc"]],
        "paging": false
    })


    jQuery('#shrinkerform').on("submit", function (e) {
        e.preventDefault();
        jQuery.post('/api', jQuery(this).serialize()).done(function (data) {
            jQuery("#shrinkResults").html('<div>URL is now Shorten: <a href="' + data.shortenURL + '" onclick="copyme()">' + data.shortenURL + '</a></div>')

        })
        Dtable.ajax.reload()
    })
    jQuery('#shrinkResults').on("click", function () {
        var link = jQuery("#shrinkResults a").attr('href');
        console.log(link);
        console.log(navigator);
        navigator.clipboard.writeText(link).then(() => {
            // Alert the user that the action took place.
            // Nobody likes hidden stuff being done under the hood!
            alert("Copied to clipboard");
        });
    })

});



