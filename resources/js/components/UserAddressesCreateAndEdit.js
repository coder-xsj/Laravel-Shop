// 注册组件
Vue.component('user-addresses-create-and-edit', {
  data() {
    return {
      province: '',
      city: '',
      district: '',
    }
  },
  methods: {
    // 把参数 val 中的值保存到组件的数据中
    // 处理 select-district 组件抛出的 change 事件，把事件的数据复制到本组件中
    onDistrictChanged(val) {
      if (val.length === 3) {
        this.province = val[0];
        this.city = val[1];
        this.district = val[2];
      }
    }
  }
});
