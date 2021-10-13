using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using TestAPIGSB.ClassesMetier;
using Xamarin.Forms;
using Newtonsoft.Json;
using TestAPIGSB.Pages;

namespace TestAPIGSB
{
    public partial class MainPage : ContentPage
    {
        public MainPage()
        {
            InitializeComponent();
        }

        private async void btnMedicaments_Clicked(object sender, EventArgs e)
        {
            PageSecteur page = new PageSecteur();
            await Navigation.PushModalAsync(new NavigationPage(page));
        }

        private async void btnPrescrires_Clicked(object sender, EventArgs e)
        {
            PagePrescrire page = new PagePrescrire();
            await Navigation.PushModalAsync(new NavigationPage(page));
        }

        private void btnDosages_Clicked(object sender, EventArgs e)
        {

        }

        private void btnTravailler_Clicked(object sender, EventArgs e)
        {

        }
    }
}
