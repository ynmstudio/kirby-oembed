<template>
  <k-field
    :label="label"
    class="oembed-field"
    :class="classObject"
    v-on-click-outside="onClickOutside"
  >
    <div class="oembed-field__input">
      <k-input
        class="oembed-field__text-input"
        v-model="oembedUrl"
        name="text"
        type="text"
        theme="field"
        @focus="open"
      />
    </div>
    <k-input v-model="color"></k-input>
    <div class="oembed-field__wrapper" v-show="active">
      <VEmbed :id="gist" :options="{ emoji: true }">
        <p>https://gist.github.com/yyx990803/7cfec746bb8cd6ae05e72f30104c0d51</p>
      </VEmbed>
      <!-- <oembed-preview
        v-model="color"
        class="oembed-field__picker"
        :class="{'oembed-field__picker--no-alpha': !editableAlpha}"
      />-->
    </div>
  </k-field>
</template>

<script>
import { mixin as onClickOutside } from "vue-on-click-outside";
import Vue from "vue";
import VEmbed from "vue-embed";
export default {
  components: {
    VEmbed
  },
  mixins: [onClickOutside],
  props: {
    label: String,
    value: String,
    default: String,
    presets: Array,
    editableAlpha: Boolean
  },
  mounted() {
    this.color = this.value || this.default;
  },
  data() {
    return {
      color: "",
      active: false
    };
  },
  methods: {
    selectColor(color) {
      this.color = color;
    },
    onClickOutside(event) {
      this.close();
    },
    open() {
      this.active = true;
    },
    close() {
      this.active = false;
    },
    toggle() {
      this.active = !this.active;
    }
  },
  computed: {
    oembedUrl: {
      get() {
        if (typeof this.color === "object") {
          if (!this.editableAlpha && this.color.a < 1) {
            this.color.a = 1;
          }
          return this.color.a == 1 ? this.color.hex : this.color.hex8;
        } else {
          return this.color;
        }
      },
      set(colorValue) {
        this.color = colorValue;
      }
    }
  },
  watch: {
    url(url, oldUrl) {
      if (oldUrl) {
        this.$emit("input", this.oembedUrl);
      }
    }
  }
};
</script>

<style lang="stylus">
.oembed-field {
  position: relative;

  &__text-input {
  }

  & &__picker {
    width: 300px;
    box-shadow: none;
  }

  &__wrapper {
    background-color: white;
    box-shadow: 0 2px 10px rgba(22, 23, 26, 0.2);
    display: inline-block;
    position: absolute;
    z-index: 10;
    // left 38px
  }

  &__presets {
    display: flex;
    padding-left: 8px;
  }

  &__preset {
    width: 24px;
    height: 24px;
    margin-bottom: 8px;
    margin-right: 4px;
    cursor: pointer;
    transition: transform 0.1s;
    transform: scale(1);
    box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.2);

    &--active {
      transform: scale(0.8);
    }
  }
}
</style>  

<style lang="stylus">
.oembed-field__picker {
  .vc-chrome-color-wrap {
    display: none;
  }

  .vc-saturation-pointer {
    transform: translate(-50%, -50%);
  }

  &--no-alpha {
    .vc-chrome-alpha-wrap, .vc-chrome-field:nth-child(3) {
      display: none;
    }
  }
}
</style>