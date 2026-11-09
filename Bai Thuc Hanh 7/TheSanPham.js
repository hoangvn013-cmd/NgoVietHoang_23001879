// Component <the-san-pham> - dùng cho Bài 2
const TheSanPham = {
  name: 'TheSanPham',

  props: {
    ten:        { type: String, required: true },
    gia:        { type: Number, required: true },
    anh:        { type: String, default: '' },
    moTa:       { type: String, default: 'Chưa có mô tả.' },
    soLuongTon: { type: Number, default: 0 }
  },

  emits: ['mua'],

  // Trạng thái riêng của từng thẻ
  data() {
    return { hienMoTa: false };
  },

  computed: {
    hetHang() { return this.soLuongTon <= 0; },
    giaDinhDang() {
      return new Intl.NumberFormat('vi-VN').format(this.gia) + ' đ';
    },
    anhHienThi() {
      if (this.anh) return this.anh;
      const svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="140">' +
        '<rect width="100%" height="100%" fill="#cfd8dc"/>' +
        '<text x="50%" y="50%" font-family="Arial" font-size="16" fill="#546e7a" ' +
        'text-anchor="middle" dominant-baseline="middle">Không có ảnh</text></svg>';
      return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
    }
  },

  methods: {
    batTatMoTa() { this.hienMoTa = !this.hienMoTa; },
    mua() { if (!this.hetHang) this.$emit('mua', this.ten); }
  },

  template: `
    <div class="the" :class="{ 'het-hang': hetHang }">
      <img :src="anhHienThi" :alt="ten">
      <h3>{{ ten }}</h3>
      <p class="gia">{{ giaDinhDang }}</p>
      <p>
        <span v-if="hetHang" class="nhan het">Hết hàng</span>
        <span v-else class="nhan con">Còn {{ soLuongTon }} sản phẩm</span>
      </p>
      <button type="button" class="btn-phu" @click="batTatMoTa">
        {{ hienMoTa ? 'Ẩn mô tả' : 'Xem mô tả' }}
      </button>
      <p v-if="hienMoTa" class="mo-ta">{{ moTa }}</p>
      <button type="button" class="btn-mua" :disabled="hetHang" @click="mua">Mua</button>
    </div>
  `
};
