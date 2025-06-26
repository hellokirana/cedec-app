import "./bootstrap";
import "laravel-datatables-vite";
import { initializeAddressDropdowns } from "./address-dropdown";

let table = new DataTable(".custom_datatable_data", {
    responsive: true,
});
