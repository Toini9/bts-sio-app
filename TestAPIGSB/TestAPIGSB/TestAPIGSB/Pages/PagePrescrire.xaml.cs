using Android.Widget;
using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using TestAPIGSB.ClassesMetier;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace TestAPIGSB.Pages
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class PagePrescrire : ContentPage
    {
        public PagePrescrire()
        {
            InitializeComponent();
        }
        HttpClient ws;
        protected override async void OnAppearing()
        {
            base.OnAppearing();
            List<Prescrire> lesPrescrires = new List<Prescrire>();

            ws = new HttpClient();
            var reponse = await ws.GetAsync("http://10.0.2.2/APIGSB/prescrire/");
            var content = await reponse.Content.ReadAsStringAsync();
            lesPrescrires = JsonConvert.DeserializeObject<List<Prescrire>>(content);
            lvPrescrires.ItemsSource = lesPrescrires;
        }

        private void lvPrescrires_ItemSelected(object sender, SelectedItemChangedEventArgs e)
        {
            if (lvPrescrires.SelectedItem != null)
            {
                txtNomPrescrire.Text = (lvPrescrires.SelectedItem as Prescrire).Nom;
            }
        }

        private async void btnModifier_Clicked(object sender, EventArgs e)
        {
            if (txtNomPrescrire.Text == null)
            {
                Toast.MakeText(Android.App.Application.Context, "Sélectionner une prescription", ToastLength.Short).Show();
            }
            else
            {
                ws = new HttpClient();
                Prescrire sec = (lvPrescrires.SelectedItem as Prescrire);
                sec.Nom = txtNomPrescrire.Text;
                JObject jsec = new JObject
                {
                    {"Id",sec.Id},
                    {"Nom",sec.Nom}
                };
                string json = JsonConvert.SerializeObject(jsec);
                StringContent content = new StringContent(json, Encoding.UTF8, "application/json");
                var reponse = await ws.PutAsync("http://10.0.2.2/APIGSB/prescrire/", content);
                List<Prescrire> lesPrescrires = new List<Prescrire>();

                ws = new HttpClient();
                reponse = await ws.GetAsync("http://10.0.2.2/APIGSB/prescrire/");
                var flux = await reponse.Content.ReadAsStringAsync();
                lesPrescrires = JsonConvert.DeserializeObject<List<Prescrire>>(flux);
                lvPrescrires.ItemsSource = lesPrescrires;
            }
        }

        private async void btnAjouter_Clicked(object sender, EventArgs e)
        {
            if (txtNomPrescrire.Text == null)
            {
                Toast.MakeText(Android.App.Application.Context, "Saisir un nom de secteur", ToastLength.Short).Show();
            }
            else
            {
                ws = new HttpClient();
                //Secteur newSecteur = new Secteur();
                //newSecteur.Nom = txtNomSecteur.Text;
                JObject sec = new JObject
                {
                    { "Sec", txtNomPrescrire.Text}
                };
                string json = JsonConvert.SerializeObject(sec);
                StringContent content = new StringContent(json, Encoding.UTF8, "application/json");

                var reponse = await ws.PostAsync("http://10.0.2.2/APIGSB/prescrire/", content);

                List<Prescrire> lesPrescrires = new List<Prescrire>();

                ws = new HttpClient();
                reponse = await ws.GetAsync("http://10.0.2.2/APIGSB/prescrire/");
                var flux = await reponse.Content.ReadAsStringAsync();
                lesPrescrires = JsonConvert.DeserializeObject<List<Prescrire>>(flux);
                lvPrescrires.ItemsSource = lesPrescrires;
            }
        }
    }
}