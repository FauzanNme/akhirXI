<template>
    <div>
      <h1>Product List</h1>
      <div v-if="products.length === 0">Loading...</div>
      <div class="card" v-for="product in products" :key="product.id">
        <h2>{{ product.nama_produk }}</h2>
        <p>{{ product.deskripsi }}</p>
        <p>Harga Beli: {{ product.harga_beli }}</p>
        <p>Harga Jual: {{ product.harga_jual }}</p>
        <div v-if="product.gambar_produk">
          <img :src="product.gambar_produk" alt="Product Image" />
        </div>
        <p>Created At: {{ product.created_at }}</p>
      </div>    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        products: []
      };
    },
    created() {
      this.fetchProducts();
    },
    methods: {
      fetchProducts() {
        axios.get('http://localhost/my-project/get_products.php')
          .then(response => {
            this.products = response.data;
          })
          .catch(error => {
            console.log(error);
          });
      }
    }
  };
  </script>
  
  <style>
  .card {
    border: 1px solid #ccc;
    padding: 16px;
    margin: 16px;
  }
  .card img {
    max-width: 100%;
    height: auto;
  }
  </style>
  