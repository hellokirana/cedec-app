export function initializeAddressDropdowns(baseUrl, initialData = {}) {
    // Fungsi untuk memuat data kota
    function loadCities(provinceCode, selectedCity = "") {
        console.log("Loading cities for province:", provinceCode);
        $.ajax({
            url: `${baseUrl}/get-cities/${provinceCode}`,
            type: "GET",
            success: function (data) {
                $("#city").empty();
                $("#city").append(
                    '<option value="">Pilih Kota/Kabupaten</option>'
                );
                data.forEach(function (city) {
                    $("#city").append(
                        `<option value="${city.code}" ${
                            city.code == selectedCity ? "selected" : ""
                        }>${city.name}</option>`
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error("Error loading cities:", error);
                console.error("Status:", status);
                console.error("Response:", xhr.responseText);
            },
        });
    }

    // Fungsi untuk memuat data kecamatan
    function loadDistricts(cityCode, selectedDistrict = "") {
        console.log("Loading districts for city:", cityCode);
        $.ajax({
            url: `${baseUrl}/get-districts/${cityCode}`,
            type: "GET",
            success: function (data) {
                $("#district").empty();
                $("#district").append(
                    '<option value="">Pilih Kecamatan</option>'
                );
                data.forEach(function (district) {
                    $("#district").append(
                        `<option value="${district.code}" ${
                            district.code == selectedDistrict ? "selected" : ""
                        }>${district.name}</option>`
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error("Error loading districts:", error);
            },
        });
    }

    // Fungsi untuk memuat data desa/kelurahan
    function loadVillages(districtCode, selectedVillage = "") {
        console.log("Loading villages for district:", districtCode);
        $.ajax({
            url: `${baseUrl}/get-villages/${districtCode}`,
            type: "GET",
            success: function (data) {
                $("#village").empty();
                $("#village").append(
                    '<option value="">Pilih Kelurahan/Desa</option>'
                );
                data.forEach(function (village) {
                    $("#village").append(
                        `<option value="${village.code}" ${
                            village.code == selectedVillage ? "selected" : ""
                        }>${village.name}</option>`
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error("Error loading villages:", error);
            },
        });
    }

    // Event listener untuk perubahan provinsi
    $("#province").on("change", function () {
        const provinceCode = $(this).val();
        if (provinceCode) {
            loadCities(provinceCode);
            $("#district")
                .empty()
                .append('<option value="">Pilih Kecamatan</option>');
            $("#village")
                .empty()
                .append('<option value="">Pilih Kelurahan/Desa</option>');
        }
    });

    // Event listener untuk perubahan kota
    $("#city").on("change", function () {
        const cityCode = $(this).val();
        if (cityCode) {
            loadDistricts(cityCode);
            $("#village")
                .empty()
                .append('<option value="">Pilih Kelurahan/Desa</option>');
        }
    });

    // Event listener untuk perubahan kecamatan
    $("#district").on("change", function () {
        const districtCode = $(this).val();
        if (districtCode) {
            loadVillages(districtCode);
        }
    });

    // Load data awal jika ada
    if (initialData.provinceCode) {
        loadCities(initialData.provinceCode, initialData.cityCode);
    }
    if (initialData.cityCode) {
        loadDistricts(initialData.cityCode, initialData.districtCode);
    }
    if (initialData.districtCode) {
        loadVillages(initialData.districtCode, initialData.villageCode);
    }
}
