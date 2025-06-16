import "./bootstrap";
import "laravel-datatables-vite";
import { initializeAddressDropdowns } from "./address-dropdown";

let table = new DataTable(".custom_datatable_data", {
    responsive: true,
});

if (document.getElementById("province")) {
    // Ambil data awal dari meta tags
    const initialData = {
        provinceCode: document.querySelector('meta[name="initial-province"]')
            ?.content,
        cityCode: document.querySelector('meta[name="initial-city"]')?.content,
        districtCode: document.querySelector('meta[name="initial-district"]')
            ?.content,
        villageCode: document.querySelector('meta[name="initial-village"]')
            ?.content,
    };

    initializeAddressDropdowns(window.location.origin, initialData);
}
