<?php

namespace App\Http\Controllers;

use App\Models\people;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

class PeopleController extends Controller
{
      
    //              METU
    public function index(): View{
        $peoples = people::latest()->paginate(5);

        return view('website.index', compact('peoples'));
    }    
    
    //             NGGAE
    public function create() : View {
        return view('website.tambah');
    }

    //              REKUES NGGAE
    public function store(Request $request) : RedirectResponse {
        $this->validate($request, [
            'nama' => 'required|min:4',
            'jasa' => 'required',
            'kontak' => 'required|min:8',
            'tentang' => 'required|min:5'
        ]);

        people::create([
            'nama' => $request->nama,
            'jasa' => $request ->jasa,
            'kontak' => $request->kontak,
            'tentang' => $request ->tentang
        ]);

        return redirect()->route('website.index')->with(['success'=>'Data Telah Di Tambahkan']);
    }
    
    public function show(string $id) : View {
        $people = people::findOrFail($id);

        return view('website.tampil', compact('people'));
    }

    public function edit(string $id) : View {
        $people = people::findOrFail($id);
        return view('website.ubah', compact('people'));
    }

    public function update(Request $request, $id) : RedirectResponse  {
        $this->validate($request, [
            'nama' => 'required|min:4',
            'jasa' => 'required',
            'kontak' => 'required|min:8',
            'tentang' => 'required|min:5'
        ]);
        $people = people::findOrFail($id);
        $people->update([
            'nama' => $request->nama,
            'jasa' => $request ->jasa,
            'kontak' => $request->kontak,
            'tentang' => $request ->tentang
        ]);
    
    return redirect()->route('website.index')->with(['success'=>'Data Berhasil Berubah']);
    }

    public function destroy($id) : RedirectResponse {
        $people = people::findOrFail($id);
        $people->delete();

        return redirect()->route('website.index')->with(['success' => 'Data Telah Terhapus']);
    }
}
