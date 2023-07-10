<template>
    <div class="bg-gray-100 p-6">
      <div class="flex items-center">
        <h2 class="text-xl font-semibold text-gray-900 text-center w-full">
          Imagens selecionadas:
        </h2>
      </div>
      <ul class="container_mini_image">
        <li v-for="image in images" :key="image.id" class="mini_image" :title="image.name">
          <div class="cont_desc_img">
            <span class="long_text lt200">{{ image.name }}</span>
            ({{ formatFileSize(image.size) }})
          </div>
          <img :src="getImageUrl(image.path)" :alt="image.name" class="thumbnail">
          <a :href="getImageUrl(image.path)" :download="getDownloadFileName(image.name)" class="download_image_btn">
            <i class="fa-solid fa-arrow-down"></i>
            Download
          </a>
        </li>
      </ul>
    </div>
  </template>

  <script>
  export default {
    props: {
      images: Array
    },
    methods: {
      getImageUrl(path) {
      
        return `${this.url}/storage/${path}`;
      },
      getDownloadFileName(imageName) {
        const fileName = imageName.split('.').slice(0, -1).join('.');
        return `${fileName}.png`;
      },
      formatFileSize(size) {
        if (size === 0) return '0 Bytes';
        const units = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(size) / Math.log(1024));
        return parseFloat((size / Math.pow(1024, i)).toFixed(2)) + ' ' + units[i];
      },
    }
  }
  </script>

  <style scoped>
    .thumbnail {
        max-width: 150px;
        max-height: 150px;
        margin-top: 10px;
    }

    .lt200 {
        max-width: 200px;
    }

    .container_mini_image {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-flow: wrap;
        margin-top: 10px;
    }

    .cont_desc_img {
        display: flex;
        flex-direction: column;
    }

    .mini_image {
        width: 220px;
        height: 275px;
        background-color: #f8f9fa;
        margin: 10px;
        border: 1px solid #d1d5db;
        padding: 10px;
        border-radius: 7px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        text-align: center;

    }

    .download_image_btn {
        margin-top: 10px;
        padding: 5px 10px;
        background-color: #198754;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
  </style>
