<template>
  <ul class="link-list">
    <li v-for="link in links">
      <a target="_blank" :href="link.link">
        <i class="fa" :class="link.fa_logo" aria-hidden="true"></i><br />
        <span>{{ link.name }}</span>
      </a>
    </li>
  </ul>
</template>

<script>
export default {
  data() {
    return {
      links: [],
    };
  },
  mounted() {
    axios.get("/api/links").then((response) => {
      this.links = response.data.data;
    });
  },
};
</script>

<style lang="scss">
@import "../../sass/variables";
.link-list {
  display: flex;
  padding: 5px 10px;
  padding-top: $categoryListHeight + 5px;
  @media (min-width: 840px) {
    padding: 5px 100px;
    padding-top: $categoryListHeight + 5px;
  }
  margin: 0;
  background: #121212;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  height: $categoryListHeight + 74px + 5px;

  li {
    flex: 1;
    list-style: none;
    margin: 0;
    padding: 0;
    text-align: center;
    a {
      text-decoration: none;
      i {
        color: #999;
        text-shadow: 1px 1px black;
        font-size: 2em;
        padding: 5px;
      }

      span {
        font-size: 0.9em;
        text-transform: lowercase;
        color: #999;
      }

      &:hover {
        i {
          color: white;
        }
        span {
          color: $primary-color;
        }
      }
    }
  }
}
</style>
