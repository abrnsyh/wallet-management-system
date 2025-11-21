import { mask } from "@alpinejs/mask";
import Alpine from "alpinejs";
import "basecoat-css/all";
import "./bootstrap";

window.Alpine = Alpine;

Alpine.plugin(mask);
Alpine.start();
