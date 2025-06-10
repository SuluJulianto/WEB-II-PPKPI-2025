# buka data file csv terlebih dahulu
#ubah format data ke list


penjualan = open("penjualan_alat_olahraga.txt", 'r')
penjualan.readline().strip()

cariwilayah=input("Wilayah yang kamu cari: ")

print("Laporan Transaksi Penjualan Bulan April - Mei 2025")
print("PT. Majoe Sejahtera")
print()
judul1=f"{'no':5} {'tanggal':5} {'namaproduk':22} {'wilayah':12} {'toko':18} {'jumlahterjual':5} {'hargasatuan':12}"

no=totalbarang=totalharga=0

for isidata in penjualan:
    isidata=isidata.strip()
    kolom=isidata.split(",")
    tanggal=kolom[0]
    namaproduk=kolom[1]
    wilayah=kolom[2].strip()
    toko=kolom[3]
    jumlahterjual=kolom[4]
    hargasatuan=int(kolom[5])
    if wilayah==cariwilayah:
       no=no+1
       totalbarang=totalbarang+int(jumlahterjual)
       totalharga=(totalharga+hargasatuan)
       formatharga=f"{hargasatuan:,}"
       detail1=f"{no:5} {tanggal:5} {namaproduk:22} {wilayah:12} {toko:18} {jumlahterjual:5} {hargasatuan:12}"
       print(detail1)
print()
print("Total seluruh barang untuk wilayah:", cariwilayah,"adalah:",totalbarang)
formatharga=f"{totalharga:,}"
print("Total seluruh harga produk:", cariwilayah,"adalah:",formatharga)