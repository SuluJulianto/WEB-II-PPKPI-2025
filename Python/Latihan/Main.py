#Menghitung Total Harga Barang

#Input
nama_barang = input("Nama barang: ")
harga_satuan = float(input("Harga satuan: "))
jumlah_beli = int(input("Jumlah beli: "))

#Proses
total_harga = harga_satuan*jumlah_beli

#Output
print("\nNama Barang:", nama_barang)
print("Total Harga: Rp", total_harga)

#if, else
if jumlah_beli<=0:
    print("\nJumlah beli harus lebih dari nol atau tidak boleh sama dengan nol")
else :
    total_harga = harga_satuan * jumlah_beli
    print("\nTotal harga barang adalah: Rp", total_harga)

print("Program Selesai")
