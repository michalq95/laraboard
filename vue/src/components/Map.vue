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
import L, { Map } from "leaflet";

function initMap(element: HTMLElement) {
  const map = L.map(element, {
    // options
  }).setView([51.97, 19.07], 7);
  L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution:
      '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
  }).addTo(map);
  return map;
}

export default defineComponent({
  emits: ["created", "removed", "setPos"],
  //   data() {
  //     return {
  //       x: 52.1,
  //       y: 19.18,
  //       zoom: 5,
  //     };
  //   },
  props: ["x", "y"],
  setup(props, { emit }) {
    const mapElement = ref();
    let map: any;
    let x = ref(props.x);
    let y = ref(props.y);
    let marker = ref();
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
          emit("created", map);
        } else {
          // Not shown - remove map
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
    <div style="height: 600px" ref="mapElement" v-once></div>
    <!-- {{ x }} {{ y }} -->
  </div>
</template>

<!-- <script lang="ts">
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
import L, { Map } from "leaflet";

function initMap(element: HTMLElement) {
  const map = L.map(element, {
    // options
  }).setView([51.97, 19.07], 7);
  L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution:
      '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
  }).addTo(map);
  return map;
}

export default {
  emits: ["created", "removed"],
  data() {
    return {
      x: 52.1,
      y: 19.18,
      zoom: 5,
      observer: null,
      map: null,
    };
  },
  created() {},
  mounted() {
    this.observer = new IntersectionObserver(
      function (entries) {
        if (entries[0].isIntersecting === true && this.$refs.mapElement) {
          this.map = initMap(this.$refs.mapElement);
          this.map.on("click", this.onMapClick);
          //   emit("created", this.map);
        } else {
          // Not shown - remove map
          //   this.removeMap();
        }
      },
      { threshold: [1] }
    );

    if (this.$refs.mapElement) {
      // Observe visibility of map container
      this.observer.observe(this.$refs.mapElement);
    } else {
      console.error("errrror");
    }
  },
  methods: {
    onMapClick(e) {
      alert("You clicked the map at " + e.latlng);
    },
    removeMap() {
      if (this.map) {
        this.map.remove();
        this.map = undefined;
      }
    },
  },


};
</script>

<template>
  <div style="height: 600px" ref="mapElement" v-once>
  </div>
</template> -->
