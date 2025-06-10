import os
# ============== Bersihkan Layar ============ #
def bersih():
    os.system('cls')

def notif(isi_notif):
    warning=input(f"{isi_notif}... tekan ENTER untuk lanjut ")

#======== Konversi ke LIST =======#
list_pengguna=[]
bukafile=open('d:\Web Programming_IF\Latihan Python_IF\.vscode\pengguna.txt', 'r')
for data in bukafile:
    data=data.strip().split(",")
    list_pengguna.append(data)
bukafile.close()

# ====== Tampilkan data ======#
def lihat_data():
    bersih()
    for baris in range(len(list_pengguna)):
        nama=list_pengguna[baris][0]
        user=list_pengguna[baris][1]
        sandi=list_pengguna[baris][2]
        admin=list_pengguna[baris][3]
        aktif=list_pengguna[baris][4]
        no=baris
        detil=f"{no:5} {nama:20} {user:10} {sandi:10} {admin:5} {aktif:5}"
        print(detil)
        print()

lihat_data()
pilih=input("1. Tambah 2. Edit 3.Hapus 4.Aktivasi 5.Sort 6.Simpan 0-Selesai")

if pilih=="0":
    notif("Program Selesai")
    exit()
elif pilih=="1":
    nama=input("Nama Lengkap : ")
    user=input("Username : ")
    sandi=input("Password : ")
    list_pengguna.append([nama,user,sandi,'0','0'])
    lihat_data()
