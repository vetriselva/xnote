<template>
    <canvas ref="chartRef"></canvas>
  </template>

  <script setup>
  import { ref, watch, onMounted, onBeforeUnmount } from 'vue'
  import { Chart } from 'chart.js/auto'

  // Props
  const props = defineProps({
    chartData: {
      type: Array,
      required: true
    }
  })

  // Refs
  const chartRef = ref(null)
  let chartInstance = null

  // Render chart
  const renderChart = () => {
    if (!chartRef.value) return

    if (chartInstance) {
      chartInstance.destroy()
    }

    chartInstance = new Chart(chartRef.value, {
      type: 'line',
      data: {
        labels: props.chartData.map(c => c.day),
        datasets: [
          {
            label: 'Daily Collection',
            data: props.chartData.map(c => c.total),
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37, 99, 235, 0.2)',
            tension: 0.4
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    })
  }

  // Lifecycle
  onMounted(renderChart)

  // Watch for data changes
  watch(
    () => props.chartData,
    renderChart,
    { deep: true }
  )

  // Cleanup
  onBeforeUnmount(() => {
    if (chartInstance) {
      chartInstance.destroy()
    }
  })
  </script>

  <style scoped>
  canvas {
    width: 100%;
    height: 300px;
  }
  </style>
