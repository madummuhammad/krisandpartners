  $(document).ready(function() {


    // Participant
    var participant=$('#participant').DataTable({
      dom: 'rtip',
      language: {
        search: ""
      }
    });

    $('#kategoriSelect').on('change', function() {
      var selectedValue = $(this).val();
      if (selectedValue !== "Pilih Kategori") {
        participant.column(3).search("^" + selectedValue + "$", true, false).draw();
      } else {
        participant.column(3).search("").draw();
      }
    });

    $('#usernameSelect').on('change', function() {
      var selectedValue = $(this).val();
      if (selectedValue !== "Pilih Username") {
        participant.column(2).search("^" + selectedValue + "$", true, false).draw();
      } else {
        participant.column(2).search("").draw();
      }
    });

    $('#urutanSelect').on('change', function() {
      var selectedValue = $(this).val();
      if (selectedValue !== "Urut Berdasarkan") {
        participant.order(selectedValue, 'asc').draw();
      } else {
        participant.order([]).draw();
      }
    });

    $('#searchInput').on('keyup', function() {
      var searchText = $(this).val();
      participant.search(searchText).draw();
    });


    // Member

    var member_table=$("#member-table").DataTable({
      dom: 'rt',
      language: {
        search: ""
      }
    })

    $('#searchMember').on('keyup', function() {
      var searchText = $(this).val();
      member_table.search(searchText).draw();
    });



    // Setting kategori
    var settings_categori=$("#tableCategorySettings").DataTable({
      dom: 'rt',
      language: {
        search: ""
      }
    })

    $('#searchCategorySettings').on('keyup', function() {
      var searchText = $(this).val();
      settings_categori.search(searchText).draw();
    });

    // Dashboard Competition
    var dashboardCompetition=$('#dashboardCompetition').DataTable({
      dom: 'rtp',
      language: {
        search: ""
      }
    });

    $('#kategoriSelect').on('change', function() {
      var selectedValue = $(this).val();
      if (selectedValue !== "Pilih Kategori") {
        dashboardCompetition.column(2).search("^" + selectedValue + "$", true, false).draw();
      } else {
        dashboardCompetition.column(2).search("").draw();
      }
    });


    $('#urutanSelect').on('change', function() {
      var selectedValue = $(this).val();
      if (selectedValue !== "Urut Berdasarkan") {
        dashboardCompetition.order(selectedValue, 'asc').draw();
      } else {
        dashboardCompetition.order([]).draw();
      }
    });

    $('#searchDashboardCompetition').on('keyup', function() {
      var searchText = $(this).val();
      dashboardCompetition.search(searchText).draw();
    });


        // Transaction
        var transaction=$("#transaction").DataTable({
          dom: 'rtp',
          language: {
            search: ""
          }
        })

        $('#searchTransaction').on('keyup', function() {
          var searchText = $(this).val();
          transaction.search(searchText).draw();
        });
      })