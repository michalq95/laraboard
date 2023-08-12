<script lang="ts">
import {
  defineComponent,
  defineEmits,
  inject,
  onMounted,
  PropType,
  reactive,
  ref,
  toRef,
  toRefs,
} from "vue";
import "leaflet/dist/leaflet.css";
import "leaflet.markercluster/dist/MarkerCluster.css";
import "leaflet.markercluster/dist/MarkerCluster.Default.css";
import icons from "../Icons";

// import "leaflet.markercluster/dist/leaflet.markercluster";

import L, { Map } from "leaflet";
import "leaflet.markercluster";
import { useRouter } from "vue-router";
function initMap(element: HTMLElement) {
  const map = L.map(element, {
    // options
  }).setView([51.97, 19.07], 7);
  L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 18,
    attribution:
      '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
  }).addTo(map);
  return map;
}

function select() {
  console.log("select");
}

export default defineComponent({
  emits: ["created", "removed", "setPos"],
  props: ["x", "y", "list"],
  setup(props, { emit }) {
    const router = useRouter();
    const mapElement = ref();
    let map: any;
    let x = ref(props.x);
    let y = ref(props.y);
    let list = props.list;
    let markerNumber = 0;

    let marker = ref();
    var markers = L.markerClusterGroup({ disableClusteringAtZoom: 17 });
    function removeMap() {
      if (map) {
        map.remove();
        map = undefined;
        emit("removed");
      }
    }
    const observer = new IntersectionObserver(
      function (entries) {
        if (entries[0].isIntersecting === true && mapElement.value) {
          removeMap();
          map = initMap(mapElement.value);
          map.on("click", onMapClick);
          if (x.value) {
            marker.value = L.marker({ lat: x.value, lng: y.value }).addTo(map);
          }
          if (list.length > markerNumber) {
            list.forEach((el) => {
              let ic =
                (icons.find((icon) => icon.name === el.icon) || {}).ob || null;

              let m;
              if (ic) m = L.marker([el.loc_x, el.loc_y], { icon: ic });
              else {
                m = L.marker([el.loc_x, el.loc_y]);
              }

              m.bindPopup(
                `${el.title}<br>` +
                  (el.bracket_high
                    ? `${el.bracket_low}-${el.bracket_high} ${el.currency}<br>`
                    : ``) +
                  // `<a href="/offers/${el.id}"target="_self" onclick="event.preventDefault() Vue.router.push('/offers/${el.id}')">Learn more</a>`
                  `<div target="_self" style="cursor:pointer; color:blue;"  onclick="event.preventDefault(); Vue.router.push('/offers/${el.slug}')">Learn more</div>`
              );
              markerNumber++;
              markers.addLayer(m);
            });
          }
          map.addLayer(markers);
          emit("created", map);
        } else {
          removeMap();
        }
      },
      { threshold: [1] }
    );

    onMounted(() => {
      if (mapElement.value) {
        // Observe visibility of map container
        observer.observe(mapElement.value);
      } else {
        console.error("errrror");
      }
    });

    function onMapClick(e) {
      x.value = e.latlng.lat;
      y.value = e.latlng.lng;
      if (!marker.value) {
        marker.value = L.marker(e.latlng).addTo(map);
      } else {
        marker.value.setLatLng(e.latlng);
      }
      emit("setPos", { x, y });
    }

    return {
      mapElement,
      x,
      y,
    };
  },
});
</script>

<template>
  <div>
    <div style="height: 600px" ref="mapElement"></div>
    <!-- {{ x }} {{ y }} -->
  </div>
</template>
