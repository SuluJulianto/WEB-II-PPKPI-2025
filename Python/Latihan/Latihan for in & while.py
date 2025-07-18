#latihan soal nomor 4
nama_barang=["kayu", "kawat", "besi", "paku"]
jumlahbarang=0
for item in nama_barang:
    jumlahbarang=jumlahbarang+1
    print("Nama barang yang dijual ke: ", jumlahbarang)
    print(item)

#atau
jumlah_barang=int(input("Berapa banyak jenis barang?")) 
total_semua=0

for i in range(jumlah_barang):
    print("Barang ke-", i + 1)
    nama=input("Nama barang:")
    harga= float(input("Harga satuan:"))
    jumlah= int(input("Jumlah beli: "))
    total=harga*jumlah
    total_semua=total_semua+total

    print("Nama barang: ", nama)
    print("Total harga: ", total)
    print()

    print("Total seluruh belanja: ", total_semua)
                 