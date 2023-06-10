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
  { name: "vue", ob: iconpython },
  { name: "php", ob: iconphp },
  { name: "vue", ob: iconvue },
];

export default icons;

// export const customIcon2 = L.icon({
//   iconUrl: 'path/to/icon2.png',
//   iconSize: [24, 24],
//   iconAnchor: [12, 24]
// });
