<script setup lang="ts">
import { onMounted, watch } from 'vue';
import { Line } from '@antv/g2plot';

const props = defineProps({
  data: Array
});

let chart;

onMounted(() => {
  chart = new Line('sent-email-chart', {
    data: props.data,
    xField: 'date',
    yField: 'count',
    smooth: true,
    color: '#4A90E2',
    xAxis: { label: { autoRotate: false } },
    yAxis: { label: { formatter: (v) => `${v}` } },
    tooltip: {
      formatter: (datum) => ({
        name: 'Sent Emails',
        value: datum.count,
      }),
    },
  });
  chart.render();
});

watch(() => props.data, (newData) => {
  chart.changeData(newData);
});
</script>

<template>
  <div id="sent-email-chart" class="w-full h-80"></div>
</template>

<style scoped>
#w-full {
  height: 300px;
}
</style>
