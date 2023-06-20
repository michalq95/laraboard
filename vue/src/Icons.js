import L from "leaflet";

const iconjs = L.icon({
  iconUrl: "./src/assets/icons/js.png",
  iconSize: [32, 32],
  iconAnchor: [16, 32],
});
const iconjava = L.icon({
  iconUrl: "./src/assets/icons/java.png",
  iconSize: [32, 32],
  iconAnchor: [16, 32],
});
const iconpython = L.icon({
  iconUrl: "./src/assets/icons/python.png",
  iconSize: [32, 32],
  iconAnchor: [16, 32],
});
const iconphp = L.icon({
  iconUrl: "./src/assets/icons/php.png",
  iconSize: [32, 32],
  iconAnchor: [16, 32],
});
const iconvue = L.icon({
  iconUrl: "./src/assets/icons/vue.png",
  iconSize: [32, 32],
  iconAnchor: [16, 32],
});
let icons = [
  { name: "js", ob: iconjs },
  { name: "java", ob: iconjava },
  { name: "python", ob: iconpython },
  { name: "php", ob: iconphp },
  { name: "vue", ob: iconvue },
];

export default icons;
