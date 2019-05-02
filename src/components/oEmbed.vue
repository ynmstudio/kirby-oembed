<template>
  <k-field :label="label" class="color-field" v-on-click-outside="onClickOutside">
    <div class="color-field__input">
      <k-url-field v-model="color" name="url" label="Url" theme="field" @focus="open"/>
    </div>
    <k-input v-model="color"></k-input>
    <div class="color-field__wrapper" v-show="active">
      <VEmbed :id="gist" :options="{ emoji: true }">
        <p>https://gist.github.com/yyx990803/7cfec746bb8cd6ae05e72f30104c0d51</p>
      </VEmbed>
      <!-- <color-preview
        v-model="color"
        class="color-field__picker"
        :class="{'color-field__picker--no-alpha': !editableAlpha}"
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
    color: {
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
        this.$emit("input", this.color);
      }
    }
  }
};
</script>

<style lang="stylus">
.color-field {
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
.color-field__picker {
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