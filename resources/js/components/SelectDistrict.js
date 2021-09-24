// 加载数据
const addressData = require('china-area-data/v5/data');
// lodash 是一个实用工具库
import _ from  'lodash';

Vue.component('select-district', {
  props: {
    // 初始化省市区的值
    initValue: {
      type: Array,
      default: () => ([]),
    }
  },
  data() {
    return {
      provinces: addressData['86'], // 省列表
      cities: {}, // 市列表
      districts: {},  // 区列表
      provinceId: '', // 当前选中的省
      cityId: '',  // 当前选中的市
      districtId: '',  // 当前选中的区
    };
  },
  // 检测 特定的值 发生改变事件
  watch: {
    // 当选择的省发生改变
    provinceId(newVal) {
      if (!newVal) {
        this.cities = {};
        this.cityId = '';
        return;
      }
      // 将市列表设置为当前省下城市
      this.cities = addressData[newVal];
      // 如果当前选中的城市不在当前省下，则将选中城市清空
      if (!this.cities[this.cityId]) {
        this.cityId = '';
      }
    },
    // 当选择的市发生改变
    cityId(newVal) {
      if (!newVal) {
        this.districts = {};
        this.districtId = '';
        return;
      }
      // 将区列表设置为当前市下的区
      this.districts = addressData[newVal];
      // 如果当前选中的区不在当前市下，则将选中城市清空
      if (!this.districts[this.districtId]) {
        this.districtId = '';
      }
    },
    // 当前的区发生变化
    districtId() {
      // 触发一个 vue 事件，得到 省-市-区 数组
      this.$emit('change', [this.provinces[this.provinceId], this.cities[this.cityId], this.districts[this.districtId]]);
    },
  },
  // 组件初始化会调用这个方法
  created() {
    this.setFromValue(this.initValue);
  },
  methods: {
    setFromValue(value) {
      // 过滤掉空值
      value = _.filter(value);
      if (value.length === 0) {
        this.provinceId = '';
        return;
      }
      // 从当前省列表中找到与数组第一个元素同名的项的索引
      const provinceId = _.findKey(this.provinces, o => o === value[0]);

      // 没找到，则清空
      if (!provinceId) {
        this.provinceId = '';
        return;
      }
      // 找到，则设置对应的 ID
      this.provinceId = provinceId;

      // 由于观察器的作用，这个时候城市列表已经变成了对应省的城市列表
      // 从当前城市列表找到与数组第二个元素同名的项的索引
      const cityId = _.findKey(addressData[provinceId], o => o === value[1]);
      // 没找到，则清空
      if (!cityId) {
        this.cityId = '';
        return;
      }
      // 找到，则设置对应的 ID
      this.cityId = cityId;

      // 观察器的作用，区列表发生变化
      // 从当前地区列表找到与数组第三个元素同名的项的索引
      const districtId = _.findKey(addressData[cityId], o => o === value[2]);
      if (!districtId) {
        this.districtId = '';
        return;
      }
      this.districtId = districtId;
    }
  }
});
